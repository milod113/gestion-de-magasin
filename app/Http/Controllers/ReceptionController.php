<?php

namespace App\Http\Controllers;

use App\Models\Reception;
use App\Models\Fournisseur;
use App\Models\Article;
use App\Models\LigneReception;
use App\Models\History;
use App\Models\Convention;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        'lignes.article'
    ])->findOrFail($id);

    return view('admin.receptions.show', compact('reception'));
}


    // Stocker une nouvelle réception avec lignes


public function store(Request $request)
{
    $request->validate([
        'date_reception'       => 'required|date',

        // ✅ new: convention instead of fournisseur
        'convention_id'        => 'required|exists:conventions,id',
        // if your PK is id_convention, use:
        // 'convention_id' => 'required|exists:conventions,id_convention',

        'reception_reference'  => 'required|string|unique:receptions,reception_reference',

        'lignes'               => 'required|array|min:1',
        'lignes.*.article_reference' => 'required|exists:articles,ref_article',
        'lignes.*.quantité'    => 'required|integer|min:1',
        'lignes.*.prix_unitaire' => 'required|numeric|min:0',
    ]);

    DB::transaction(function () use ($request) {

        // calculate total
        $total = 0;
        foreach ($request->lignes as $ligne) {
            $total += $ligne['quantité'] * $ligne['prix_unitaire'];
        }

        // ✅ create reception with convention_id
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

            // create reception line
            LigneReception::create([
                'reception_id'      => $reception->id_reception,
                'article_reference' => $ligne['article_reference'],
                'quantité'          => $ligne['quantité'],
                'prix_unitaire'     => $ligne['prix_unitaire'],
                'sous_total'        => $ligne['quantité'] * $ligne['prix_unitaire'],
                'reference_BL'      => $reception->reception_reference,
            ]);

            // update stock & weighted avg price (PUMP)
            $article = Article::where('ref_article', $ligne['article_reference'])->first();

            if ($article) {
                $old_stock = $article->quantite_en_stock ?? 0;
                $old_price = $article->prix ?? 0;

                $new_qty   = $ligne['quantité'];
                $new_price = $ligne['prix_unitaire'];

                $new_stock = $old_stock + $new_qty;

                if ($new_stock > 0) {
                    $new_average_price =
                        (($old_stock * $old_price) + ($new_qty * $new_price)) / $new_stock;
                } else {
                    $new_average_price = $new_price;
                }

                $article->update([
                    'quantite_en_stock' => $new_stock,
                    'prix'              => round($new_average_price, 2),
                ]);

                // add history entry
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
    });

    return redirect()
        ->route('receptions.index')
        ->with('success', 'Réception créée avec succès, stock et historique mis à jour.');
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
