<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Service;
use App\Models\User;
use App\Models\Categorie;
use App\Models\Article;
use App\Models\LigneCommande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Auth;



class CommandeController extends Controller
{
public function index(Request $request)
{
    $query = Commande::with(['service', 'user'])
        ->orderBy('date_commande', 'desc');

    // Filter by reference
    if ($request->filled('ref_commande')) {
        $query->where('ref_commande', 'like', '%' . $request->ref_commande . '%');
    }

    // Filter by exact date
    if ($request->filled('date_commande')) {
        $query->whereDate('date_commande', $request->date_commande);
    }

    // Filter by month/year
    if ($request->filled('month')) {
        $query->whereMonth('date_commande', $request->month);
    }
    if ($request->filled('year')) {
        $query->whereYear('date_commande', $request->year);
    }

    $commandes = $query->paginate(10)->appends($request->query());

    return view('admin.commande.index', compact('commandes'));
}



  public function create()
{
    $services = Service::all();
    $users = User::all();
    $categories = Categorie::all(); // Ajoute les catégories
    $articles = Article::all(); // Tous les articles (optionnel si on utilise Ajax)

    return view('admin.commande.create', compact('services', 'users', 'categories', 'articles'));
}




public function store(Request $request)
{

    try {
        // 1️⃣ Validate main commande data
        $validated = $request->validate([
            'date_commande' => 'required|date',
            'service_code' => 'required',
            'ref_commande' => 'required|unique:commandes,ref_commande',
            'type_bon_commande' => 'required|string|max:50',
            'beneficiare' => 'nullable|string|max:100',
            'lignes' => 'required|array|min:1',
            'lignes.*.article_reference' => 'required|exists:articles,ref_article',
            'lignes.*.quantité' => 'required|numeric|min:1',
        ]);
        $validated['user_id'] = Auth::id();

        // 2️⃣ Create commande
        $commande = Commande::create([
            'date_commande' => $validated['date_commande'],
            'service_code' => $validated['service_code'],
            'ref_commande' => $validated['ref_commande'],
            'etat_commande' => 1,
            'type_bon_commande' => $validated['type_bon_commande'],
            'beneficiare' => $validated['beneficiare'] ?? null,
            'user_id' => $validated['user_id'],
        ]);

        // 3️⃣ Save each ligne commande
        foreach ($validated['lignes'] as $ligne) {
            LigneCommande::create([
                'commande_ref' => $commande->ref_commande,
                'article_reference' => $ligne['article_reference'],
                'quantité' => $ligne['quantité'],
            ]);
        }

        return redirect()
            ->route('commandes.index')
            ->with('success', 'Commande et lignes créées avec succès.');

    } catch (Exception $e) {
dd($e->getMessage(), $e->getTraceAsString());

        // Log error message + stack trace
        Log::error('Erreur lors de la création de la commande', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        // Optional: Show error to the user
        return back()
            ->withErrors(['error' => 'Une erreur est survenue: ' . $e->getMessage()])
            ->withInput();
    }
}




    public function show(Commande $commande)
    {
        return view('admin.commande.show', compact('commande'));
    }

    public function edit(Commande $commande)
    {
        $services = Service::all();
        $users = User::all();
        return view('admin.commande.edit', compact('commande', 'services', 'users'));
    }

    public function update(Request $request, Commande $commande)
    {
        $validated = $request->validate([
            'date_commande' => 'required|date',
            'service_code' => 'required',
            'ref_commande' => 'required|unique:commandes,ref_commande,' . $commande->id_commande . ',id_commande',
            'etat_commande' => 'required|in:0,1',
            'type_bon_commande' => 'required|string|max:50',
            'beneficiare' => 'nullable|string|max:100',
            'user_id' => 'required|exists:users,id',
        ]);

        $commande->update($validated);

        return redirect()->route('commandes.index')->with('success', 'Commande mise à jour.');
    }

    public function destroy(Commande $commande)
    {
        $commande->delete();
        return redirect()->route('commandes.index')->with('success', 'Commande supprimée.');
    }
}
