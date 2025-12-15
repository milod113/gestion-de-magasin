<?php

namespace App\Http\Controllers;

use App\Models\Convention;
use App\Models\ConventionArticle;
use App\Models\Immobilier\EquipmentCategory;
use App\Models\Immobilier\Equipment;

use App\Models\Categorie;
use App\Models\Fournisseur;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LigneReception;

class ConventionController extends Controller
{

public function items(Convention $convention)
{
    $convention->load([
        'lignes.article',
        'lignes.equipment',
    ]);

    $items = $convention->lignes->map(function ($l) {

        if ($l->item_type === 'equipment') {
            return [
                'type' => 'equipment',                 // ⚠️ IMPORTANT
                'id' => $l->equipment_id,
                'label' => $l->equipment?->label,
                'qty_convenue' => $l->quantite_convenue,
                'price' => $l->prix_convenu,           // ✅ renommé
            ];
        }

        return [
            'type' => 'article',
            'id' => $l->article_id,
            'label' => $l->article?->designation,
            'qty_convenue' => $l->quantite_convenue,
            'price' => $l->prix_convenu,               // ✅ renommé
        ];
    });

    return response()->json([
        'items' => $items
    ]);
}




    public function index()
    {
        $conventions = Convention::with('fournisseur')
            ->orderBy('annee', 'desc')
            ->latest()
            ->paginate(10);

        return view('admin.conventions.index', compact('conventions'));
    }

 // catégorie d’articles de stock (à adapter si nom différent)



public function create()
{
    // Fournisseurs pour la convention
    $fournisseurs = Fournisseur::orderBy('raison_sociale')->get();

    // Articles de stock
    $articles = Article::with('categorie')->orderBy('designation')->get();

    // Catégories d’articles de stock
    $articleCategories = Categorie::orderBy('designation')->get();

    // Catégories d’équipements biomédicaux
    $equipmentCategories = EquipmentCategory::orderBy('name')->get();

    // 🔹 Équipements biomédicaux / immobilier
    $equipments = Equipment::with('category')->orderBy('label')->get(); // adapte 'label' si besoin

    return view('admin.conventions.create', compact(
        'fournisseurs',
        'articles',
        'articleCategories',
        'equipmentCategories',
        'equipments'
    ));
}









public function store(Request $request)
{
   // dd($request->all());
    $validated = $request->validate([
        'fournisseur_id'  => 'required|exists:fournisseurs,id_fournisseur',
        'reference'       => 'required|string|max:255|unique:conventions,reference',
        'annee'           => 'required|digits:4',
        'date_debut'      => 'nullable|date',
        'date_fin'        => 'nullable|date|after_or_equal:date_debut',
        'statut'          => 'nullable|in:brouillon,actif,clos',
        'notes'           => 'nullable|string',

        'scope'           => 'required|in:stock,equipment',

        'stock_category_id'     => 'exclude_if:scope,equipment|nullable|required_if:scope,stock|exists:categories,id_categorie',
        'equipment_category_id' => 'exclude_if:scope,stock|nullable|required_if:scope,equipment|exists:equipment_categories,id',

        'articles'                      => 'exclude_if:scope,equipment|required_if:scope,stock|array|min:1',
        'articles.*.article_id'         => 'exclude_if:scope,equipment|required_if:scope,stock|exists:articles,id_article',
        'articles.*.quantite_convenue'  => 'exclude_if:scope,equipment|nullable|integer|min:0',
        'articles.*.prix_convenu'       => 'exclude_if:scope,equipment|required_if:scope,stock|numeric|min:0',
        'articles.*.unite'              => 'exclude_if:scope,equipment|nullable|string|max:50',

        'equipments'                       => 'exclude_if:scope,stock|required_if:scope,equipment|array|min:1',
        'equipments.*.equipment_id'        => 'exclude_if:scope,stock|required_if:scope,equipment|exists:equipment,id',
        'equipments.*.quantite_convenue'   => 'exclude_if:scope,stock|nullable|integer|min:0',
        'equipments.*.prix_convenu'        => 'exclude_if:scope,stock|required_if:scope,equipment|numeric|min:0',
        'equipments.*.unite'               => 'exclude_if:scope,stock|nullable|string|max:50',
    ]);

    DB::beginTransaction();

    try {
        $convention = Convention::create([
            'fournisseur_id'        => $validated['fournisseur_id'],
            'reference'             => $validated['reference'],
            'annee'                 => $validated['annee'],
            'date_debut'            => $validated['date_debut'] ?? null,
            'date_fin'              => $validated['date_fin'] ?? null,
            'statut'                => $validated['statut'] ?? 'brouillon',
            'notes'                 => $validated['notes'] ?? null,

            'scope'                 => $validated['scope'],
            'stock_category_id'     => $validated['stock_category_id'] ?? null,
            'equipment_category_id' => $validated['equipment_category_id'] ?? null,
        ]);

        // STOCK
        if ($convention->scope === 'stock') {
            foreach (($validated['articles'] ?? []) as $ligne) {
                if (empty($ligne['article_id'])) continue;

                ConventionArticle::create([
                    'convention_id'      => $convention->id,
                    'item_type'          => 'article',
                    'article_id'         => $ligne['article_id'],
                    'equipment_id'       => null,
                    'quantite_convenue'  => $ligne['quantite_convenue'] ?? null,
                    'prix_convenu'       => $ligne['prix_convenu'],
                    'unite'              => $ligne['unite'] ?? null,
                ]);
            }
        }

        // EQUIPEMENT
        if ($convention->scope === 'equipment') {
            foreach (($validated['equipments'] ?? []) as $ligne) {
                if (empty($ligne['equipment_id'])) continue;

                ConventionArticle::create([
                    'convention_id'      => $convention->id,
                    'item_type'          => 'equipment',
                    'article_id'         => null,
                    'equipment_id'       => $ligne['equipment_id'],
                    'quantite_convenue'  => $ligne['quantite_convenue'] ?? null,
                    'prix_convenu'       => $ligne['prix_convenu'],
                    'unite'              => $ligne['unite'] ?? null,
                ]);
            }
        }

        DB::commit();

        return redirect()
            ->route('conventions.index')
            ->with('success', 'Convention/marché créé avec succès.');
    } catch (\Throwable $e) {
        DB::rollBack();
        // Pour voir l’erreur exacte si besoin :
        // dd($e->getMessage());

        return back()
            ->withInput()
            ->with('error', 'Erreur lors de la création : '.$e->getMessage());
    }
}






public function show($id)
{
    $convention = Convention::with([
            'fournisseur',
            'stockCategory',
            'equipmentCategory',
            'lignes.article.categorie',   // article + catégorie d’article
            'lignes.equipment.category',  // équipement + catégorie d’équipement
        ])
        ->findOrFail($id);

    // Optionnel : séparer pour que ce soit plus simple dans la vue
    $stockLines = $convention->lignes->where('item_type', 'article');
    $equipmentLines = $convention->lignes->where('item_type', 'equipment');

    return view('admin.conventions.show', compact(
        'convention',
        'stockLines',
        'equipmentLines'
    ));
}

}

