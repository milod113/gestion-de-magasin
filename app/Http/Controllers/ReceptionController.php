<?php

namespace App\Http\Controllers;

use App\Models\Reception;
use App\Models\Fournisseur;
use App\Models\Article;
use App\Models\LigneReception;
use App\Models\History;
use App\Models\Convention;
use App\Models\Immobilier\Equipment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ReceptionController extends Controller
{
    // Liste des réceptions


public function index(Request $request)
{
    $search        = $request->input('search');          // free text
    $fournisseurId = $request->input('fournisseur_id');  // filter by supplier
    $conventionId  = $request->input('convention_id');   // filter by convention
    $dateFrom      = $request->input('date_from');       // start date
    $dateTo        = $request->input('date_to');         // end date

    $receptions = Reception::with(['convention.fournisseur', 'user'])
        ->when($search, function ($q) use ($search) {
            $q->where(function ($qq) use ($search) {
                $qq->where('reception_reference', 'like', "%{$search}%")
                   ->orWhere('Total', 'like', "%{$search}%");
            });
        })
        ->when($conventionId, function ($q) use ($conventionId) {
            $q->where('convention_id', $conventionId);
        })
        ->when($fournisseurId, function ($q) use ($fournisseurId) {
            // filter receptions by supplier through convention
            $q->whereHas('convention', function ($qc) use ($fournisseurId) {
                $qc->where('fournisseur_id', $fournisseurId);
            });
        })
        ->when($dateFrom, function ($q) use ($dateFrom) {
            $q->whereDate('date_reception', '>=', $dateFrom);
        })
        ->when($dateTo, function ($q) use ($dateTo) {
            $q->whereDate('date_reception', '<=', $dateTo);
        })
        ->orderBy('date_reception', 'desc')
        ->paginate(15)
        ->appends($request->query());

    // for filter dropdowns
    $fournisseurs = Fournisseur::orderBy('raison_sociale')->get();
    // change column if needed (ex: designation / nom)

    $conventions = Convention::with('fournisseur')
        ->orderBy('reference')
        ->get();

    return view('admin.receptions.index', compact(
        'receptions',
        'fournisseurs',
        'conventions',
        'search',
        'fournisseurId',
        'conventionId',
        'dateFrom',
        'dateTo'
    ));
}



    // Formulaire création réception

public function create()
{
    $conventions = Convention::with('fournisseur')
        ->orderBy('reference')
        ->get();

    $articles = Article::all();

    return view('admin.receptions.create', compact('conventions', 'articles'));
}
public function show($id)
{
    $reception = Reception::with([
        'convention.fournisseur',
        'user',
        'lignes.item', // ✅ polymorph: Article OR Equipment
    ])->findOrFail($id);

    return view('admin.receptions.show', compact('reception'));
}




public function pdf($id)
{
    $reception = Reception::with([
        'convention.fournisseur',
        'user',
        'lignes.item', // ✅ Article OR Equipment
    ])->findOrFail($id);

   $pdf = Pdf::loadView('admin.receptions.pdf', compact('reception'))
    ->setPaper('a4', 'landscape'); // ✅ au lieu de portrait
    return $pdf->download('BL-'.$reception->reception_reference.'.pdf');
    // ou afficher dans le navigateur:
    // return $pdf->stream('BL-'.$reception->reception_reference.'.pdf');
}


    // Stocker une nouvelle réception avec lignes




public function store(Request $request)
{
    $request->validate([
        'date_reception'       => ['required', 'date'],
        'convention_id'        => ['required', 'exists:conventions,id'],
        'reception_reference'  => ['required', 'string', 'unique:receptions,reception_reference'],

        'lignes'               => ['required', 'array', 'min:1'],

        // polymorph
        'lignes.*.item_type'   => ['required', Rule::in(['App\\Models\\Article', 'App\\Models\\Immobilier\\Equipment'])],
        'lignes.*.item_id'     => ['required', 'integer'],

        'lignes.*.quantité'    => ['required', 'integer', 'min:1'],
        'lignes.*.prix_unitaire' => ['required', 'numeric', 'min:0'],

        // série: obligatoire uniquement si equipment
        'lignes.*.n_serie'     => ['nullable', 'string', 'max:255'],
    ]);

    // ✅ Validation conditionnelle n_serie + existence item_id
    foreach ($request->lignes as $k => $ligne) {
        $type = $ligne['item_type'] ?? null;
        $id   = $ligne['item_id'] ?? null;

        if ($type === 'App\\Models\\Immobilier\\Equipment') {
            if (empty($ligne['n_serie'])) {
                return back()
                    ->withErrors(["lignes.$k.n_serie" => "Le N° série est obligatoire pour un équipement."])
                    ->withInput();
            }

            if (!Equipment::whereKey($id)->exists()) {
                return back()
                    ->withErrors(["lignes.$k.item_id" => "Équipement introuvable."])
                    ->withInput();
            }
        }

        if ($type === 'App\\Models\\Article') {
            if (!Article::whereKey($id)->exists()) {
                return back()
                    ->withErrors(["lignes.$k.item_id" => "Article introuvable."])
                    ->withInput();
            }
        }
    }

    DB::transaction(function () use ($request) {

        // total
        $total = 0;
        foreach ($request->lignes as $ligne) {
            $total += (int)$ligne['quantité'] * (float)$ligne['prix_unitaire'];
        }

        // create reception
        $reception = Reception::create([
            'date_reception'      => $request->date_reception,
            'convention_id'       => $request->convention_id,
            'user_id'             => Auth::id(),
            'Total'               => $total,
            'reception_reference' => $request->reception_reference,
            'etat_reception'      => 1,
            'type_reception'      => 1,
        ]);

        foreach ($request->lignes as $ligne) {

            $qty  = (int)$ligne['quantité'];
            $pu   = (float)$ligne['prix_unitaire'];
            $sub  = $qty * $pu;

            $itemType = $ligne['item_type'];
            $itemId   = (int)$ligne['item_id'];

            // compat: remplir article_reference seulement si article
            $articleReference = null;
            if ($itemType === 'App\\Models\\Article') {
                $articleReference = Article::find($itemId)?->ref_article;
            }

            // create reception line
            LigneReception::create([
                'reception_id'      => $reception->id_reception,

                'item_type'         => $itemType,
                'item_id'           => $itemId,

                'article_reference' => $articleReference, // nullable if equipment
                'n_serie'           => $ligne['n_serie'] ?? null,

                'quantité'          => $qty,
                'prix_unitaire'     => $pu,
                'sous_total'        => $sub,
                'reference_BL'      => $reception->reception_reference,
            ]);

            // ✅ Stock update + history only for Articles
            if ($itemType === 'App\\Models\\Article') {
                $article = Article::find($itemId);

                if ($article) {
                    $old_stock = $article->quantite_en_stock ?? 0;
                    $old_price = $article->prix ?? 0;

                    $new_stock = $old_stock + $qty;

                    $new_average_price = $new_stock > 0
                        ? (($old_stock * $old_price) + ($qty * $pu)) / $new_stock
                        : $pu;

                    $article->update([
                        'quantite_en_stock' => $new_stock,
                        'prix'              => round($new_average_price, 2),
                    ]);

                    History::create([
                        'article_reference' => $article->ref_article,
                        'prix'              => round($new_average_price, 2),
                        'quantite'          => $new_stock,
                        'type_mouvement'    => 'Entrée',
                        'description'       => 'Nouveau Bon De livraison',
                        'date_changement'   => now(),
                    ]);
                }
            }

            // ✅ Equipement: ici tu peux ajouter ta logique (ex: marquer reçu, enregistrer n_serie, etc.)
            // if ($itemType === 'App\\Models\\Immobilier\\Equipment') { ... }
        }
    });

    return redirect()
        ->route('receptions.index')
        ->with('success', 'Réception créée avec succès.');
}





    // Afficher détails d’une réception avec lignes


    // Supprimer une réception
    public function destroy($id)
    {
        $reception = Reception::findOrFail($id);
        $reception->delete();
        return redirect()->route('receptions.index')->with('success', 'Réception supprimée avec succès.');
    }
}
