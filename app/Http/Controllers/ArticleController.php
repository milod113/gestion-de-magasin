<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ArticleController extends Controller
{

   public function export(): StreamedResponse
    {
        $fileName = 'articles_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $columns = [
            'ID',
            'Référence',
            'Désignation',
            'Catégorie',
            'Quantité en stock',
            'Unité',
            'Prix',
            'Créé le',
        ];

        return response()->stream(function () use ($columns) {
            $handle = fopen('php://output', 'w');

            // Support Excel UTF-8
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // En-têtes
            fputcsv($handle, $columns, ';');

            // Récupérer tous les articles avec leur catégorie
            $articles = Article::with('categorie')->orderBy('id_article')->get();

            foreach ($articles as $article) {
                fputcsv($handle, [
                    $article->id_article,
                    $article->ref_article,
                    $article->designation,
                    optional($article->categorie)->designation ?? '',
                    $article->quantite_en_stock,
                    $article->unité,
                    $article->prix,
                    optional($article->created_at)->format('d/m/Y H:i'),
                ], ';');
            }

            fclose($handle);
        }, 200, $headers);
    }



public function show(Request $request, $id)
{
    $type = $request->get('type_mouvement'); // ENTREE, SORTIE ou null

    $article = Article::with([
        'categorie',
        'histories' => function ($q) use ($type) {
            if (in_array($type, ['ENTREE', 'SORTIE','AJUSTEMENT'])) {
                $q->where('type_mouvement', $type);
            }
            // sinon on ne filtre pas -> tous les mouvements
        }
    ])->findOrFail($id);

    $categories = Categorie::all();

    return view('admin.articles.show', compact('article', 'categories', 'type'));
}








public function index(Request $request)
{
    $search     = $request->input('search');
    $categoryId = $request->input('category_id');

    $articles = Article::with('categorie')
        ->when($search, function ($q) use ($search) {
            $q->where(function ($qq) use ($search) {
                $qq->where('designation', 'like', "%{$search}%")
                   ->orWhere('ref_article', 'like', "%{$search}%")
                   ->orWhere('prix', 'like', "%{$search}%")
                   ->orWhere('unité', 'like', "%{$search}%"); 
            });
        })
        ->when($categoryId, function ($q) use ($categoryId) {
            $q->where('category_id', $categoryId);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->appends($request->query());

    $categories = Categorie::orderBy('designation')->get(); 
    // change 'name' if your column is different (ex: libelle)

    return view('admin.articles.index', compact(
        'articles',
        'categories',
        'search',
        'categoryId'
    ));
}


    public function create()
    {
        $categories = Categorie::all();
        return view('admin.articles.create', compact('categories'));
    }

  public function store(Request $request)
{
    $validated = $request->validate([
        'ref_article'       => 'required|integer|unique:articles,ref_article',
        'designation'       => 'required|string|max:255',
        'quantite_en_stock' => 'nullable|integer',
        'category_id'       => 'required|exists:categories,id_categorie',
        'unité'             => 'nullable|string|max:50',
        'prix'              => 'nullable|numeric',
        'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // added image validation
    ]);

    // Handle image upload if exists
    if ($request->hasFile('image')) {
        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/articles', $imageName);
        $validated['image'] = $imageName;
    }

    Article::create($validated);

    return redirect()->route('articles.index')->with('success', 'Article ajouté avec succès.');
}

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories = Categorie::all();

        return view('admin.articles.edit', compact('article', 'categories'));
    }

public function update(Request $request, $id)
{
    // Find the article by ID
    $article = Article::findOrFail($id);

    // Validate the request data
    $validated = $request->validate([
        'ref_article'       => 'required|integer|unique:articles,ref_article,' . $article->id_article . ',id_article',
        'designation'       => 'required|string|max:255',
        'quantite_en_stock' => 'nullable|integer',
        'category_id'       => 'required|exists:categories,id_categorie',
        'unité'             => 'nullable|string|max:50',
        'prix'              => 'nullable|numeric',
        'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // If a new image is uploaded
    if ($request->hasFile('image')) {
        // Delete the old image if it exists
        if ($article->image && Storage::exists('public/articles/' . $article->image)) {
            Storage::delete('public/articles/' . $article->image);
        }

        // Store the new image
        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/articles', $imageName);
        $validated['image'] = $imageName; // Update validated data with new image name
    }

    // Update the article with validated data
    $article->update($validated);

    return redirect()->route('articles.index')->with('success', 'Article mis à jour avec succès.');
}

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Article supprimé avec succès.');
    }
}
