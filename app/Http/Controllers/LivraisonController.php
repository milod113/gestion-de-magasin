<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\LigneCommande;
use App\Models\Livraison;
use App\Models\LigneLivraison;
use App\Models\Article;
use App\Models\History;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;



use Illuminate\Support\Facades\Auth;

class LivraisonController extends Controller
{
  public function create($commande_ref)
{
    // No need to urldecode here, Laravel will give you the full string with slashes
    $commande = Commande::with('lignes.article')
        ->where('ref_commande', $commande_ref)
        ->firstOrFail();

    return view('admin.livraison.create', compact('commande'));
}




public function store(Request $request)
{
    $validated = $request->validate([
        'commande_ref' => 'required|exists:commandes,ref_commande',
        'date_livraison' => 'required|date',
        'lignes' => 'required|array',
        'lignes.*.article_ref' => 'required|exists:articles,ref_article',
        'lignes.*.quantite_livree' => 'required|integer|min:1',
    ]);

    DB::transaction(function () use ($validated) {
        // Create livraison
        $livraison = Livraison::create([
            'commande_ref' => $validated['commande_ref'],
            'date_livraison' => $validated['date_livraison'],
            'livré_par' => Auth::user()->name,
            'etat_livraison' => 1,
            'user_id' => Auth::id(),
        ]);

        // ✅ Update commande status
        Commande::where('ref_commande', $validated['commande_ref'])
            ->update(['etat_commande' => 2]);

        foreach ($validated['lignes'] as $ligne) {
            // Create ligne livraison
            LigneLivraison::create([
                'id_livraison_1' => $livraison->id_livraison,
                'artc_ref' => $ligne['article_ref'],
                'quantité_livré' => $ligne['quantite_livree'],
            ]);

            // Get the article
            $article = Article::where('ref_article', $ligne['article_ref'])->first();

            if ($article) {
                // Create history record
                History::create([
                    'article_reference' => $article->ref_article,
                    'type_mouvement' => 'SORTIE',
                    'quantite' => $ligne['quantite_livree'],
                    'prix' => $article->prix, // keep current price
                    'date_mouvement' => now(),
                    'description' => $livraison->commande_ref,
                ]);

                // Update stock
                $new_stock = max(0, $article->quantite_en_stock - $ligne['quantite_livree']);
                $article->update([
                    'quantite_en_stock' => $new_stock,
                ]);
            }
        }
    });

    return redirect()->route('commandes.index')->with('success', 'Livraison créée avec succès, commande validée et stock mis à jour.');
}

public function show($commande_ref)
{
    // Get commande with its lignes and linked articles
    $commande = Commande::with(['lignes.article', 'livraisons.lignes'])
        ->where('ref_commande', $commande_ref)
        ->firstOrFail();

    return view('admin.livraison.show', compact('commande'));
}



public function consommationParService(Request $request)
{
    $query = LigneLivraison::select(
            DB::raw('services.id_service as service_id'),
            DB::raw('services.service_fr as service_nom'),
            DB::raw('DATE_FORMAT(livraisons.date_livraison, "%Y-%m") as mois'),
            DB::raw('SUM(ligne_livraison.quantité_livré * articles.prix) as total_consommation')
        )
        ->join('livraisons', 'ligne_livraison.id_livraison_1', '=', 'livraisons.id_livraison')
        ->join('commandes', 'livraisons.commande_ref', '=', 'commandes.ref_commande')
        ->join('services', 'commandes.service_code', '=', 'services.code_service')
        ->join('articles', 'ligne_livraison.artc_ref', '=', 'articles.ref_article');

    // 📌 Filtre par année
    if ($request->filled('annee')) {
        $query->whereYear('livraisons.date_livraison', $request->annee);
    }

    // 📌 Filtre par mois
    if ($request->filled('mois')) {
        $query->whereMonth('livraisons.date_livraison', $request->mois);
    }

    // 📌 Filtre par service
    if ($request->filled('service_id')) {
        $query->where('services.id_service', $request->service_id);
    }

    $stats = $query
        ->groupBy(
            'services.id_service',
            'services.service_fr',
            DB::raw('DATE_FORMAT(livraisons.date_livraison, "%Y-%m")')
        )
        ->orderBy('mois')
        ->get();

    // Liste des services pour le filtre
    $services = DB::table('services')->select('id_service', 'service_fr')->orderBy('service_fr')->get();

    return view('admin.statistiques.show', compact('stats', 'services'));
}


public function detailsLivraisonsParService(Request $request)
{
    // 📌 Default to current month/year
    $month = $request->input('month', date('m'));
    $year = $request->input('year', date('Y'));

    $query = DB::table('ligne_livraison')
        ->join('livraisons', 'ligne_livraison.id_livraison_1', '=', 'livraisons.id_livraison')
        ->join('commandes', 'livraisons.commande_ref', '=', 'commandes.ref_commande')
        ->join('services', 'commandes.service_code', '=', 'services.code_service')
        ->join('articles', 'ligne_livraison.artc_ref', '=', 'articles.ref_article')
        ->select(
            'services.id_service',
            'services.service_fr',
            'articles.designation',
            'articles.prix as prix_unitaire',
            'ligne_livraison.quantité_livré',
            DB::raw('(ligne_livraison.quantité_livré * articles.prix) as sous_total')
        )
        ->whereMonth('livraisons.date_livraison', $month)
        ->whereYear('livraisons.date_livraison', $year);

    // 📌 Filter by service if provided
    if ($request->filled('service_id')) {
        $query->where('services.id_service', $request->service_id);
    }

    $details = $query
        ->orderBy('services.service_fr')
        ->orderBy('articles.designation')
        ->get()
        ->groupBy('service_fr'); // Group by service for view display
    $services = DB::table('services')->select('id_service', 'service_fr')->orderBy('service_fr')->get();

    return view('admin.statistiques.details_services', compact('details', 'month', 'year','services'));
}



// dans StatistiquesController
private function getDetailsData($mois = null, $annee = null)
{
        // Convert month/year to integers
   
    $query = DB::table('ligne_livraison')
        ->join('livraisons', 'ligne_livraison.id_livraison_1', '=', 'livraisons.id_livraison')
        ->join('commandes', 'livraisons.commande_ref', '=', 'commandes.ref_commande')
        ->join('services', 'commandes.service_code', '=', 'services.code_service')
        ->join('articles', 'ligne_livraison.artc_ref', '=', 'articles.ref_article')
        ->select(
            'services.id_service',
            'services.service_fr',
            'articles.designation',
            DB::raw('articles.prix as prix_unitaire'),
            // aliaser la colonne accentuée en qte_livree
            DB::raw('ligne_livraison.`quantité_livré` as qte_livree'),
            DB::raw('(ligne_livraison.`quantité_livré` * articles.prix) as sous_total')
        )
        ->orderBy('services.service_fr')
        ->orderBy('articles.designation');

    if ($mois) {
        $query->whereMonth('livraisons.date_livraison', $mois);
    }
    if ($annee) {
        $query->whereYear('livraisons.date_livraison', $annee);
    }

    return $query->get()->groupBy('service_fr'); // Collection groupée par nom du service
}

public function exportDetailsParServicePdf(Request $request)
{
    $mois = $request->input('mois') ? (int) $request->input('mois') : null;
    $annee = $request->input('annee') ? (int) $request->input('annee') : null;

    $stats = $this->getDetailsData($mois, $annee); // collection groupée

    // loadView -> blade spécifique pour le PDF
    $pdf = Pdf::loadView('admin.statistiques.pdf_consommation', compact('stats','mois','annee'))
              ->setPaper('a4', 'portrait');

    $filename = 'details_livraisons_' . ($mois ?? 'all') . '_' . ($annee ?? date('Y')) . '.pdf';

    return $pdf->download($filename);
}






public function exportConsommationParServicePdf(Request $request)
{
    $queries = LigneLivraison::select(
            DB::raw('services.service_fr as service_nom'),
            DB::raw('SUM(ligne_livraison.quantité_livré * articles.prix) as total_consommation')
        )
        ->join('livraisons', 'ligne_livraison.id_livraison_1', '=', 'livraisons.id_livraison')
        ->join('commandes', 'livraisons.commande_ref', '=', 'commandes.ref_commande')
        ->join('services', 'commandes.service_code', '=', 'services.code_service')
        ->join('articles', 'ligne_livraison.artc_ref', '=', 'articles.ref_article');

    // Filters
    if ($request->filled('annee')) {
        $queries->whereYear('livraisons.date_livraison', $request->annee);
    }
    if ($request->filled('mois')) {
        $queries->whereMonth('livraisons.date_livraison', $request->mois);
    }
    if ($request->filled('service_id')) {
        $queries->where('services.id_service', $request->service_id);
    }

    // Get ALL results, no pagination
    $stats = $queries
        ->groupBy('services.service_fr')
        ->orderBy('services.service_fr')
        ->get();

    $totalGlobal = $stats->sum('total_consommation');

    // Pass month/year to view so your header works
    $pdf = Pdf::loadView('admin.statistiques.pdf_recap', [
        'stats'       => $stats,
        'totalGlobal' => $totalGlobal,
        'mois'        => $request->mois,
        'annee'       => $request->annee,
    ])->setPaper('A4', 'portrait');

    return $pdf->download('consommation_par_service.pdf');
}








}