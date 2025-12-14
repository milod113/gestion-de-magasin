<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleApiController extends Controller
{
    public function getByCategorie(Request $request)
    {
        $request->validate([
            'categorie_id' => 'required|exists:categories,id_categorie'
        ]);

        $articles = Article::where('category_id', $request->categorie_id)
                          ->select('id_article as id', 'designation','ref_article')
                          ->get();

        return response()->json($articles);
    }
}


