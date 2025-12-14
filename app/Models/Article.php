<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $primaryKey = 'id_article';

    protected $fillable = [
        'ref_article',
        'designation',
        'quantite_en_stock',
        'category_id',
        'unité',
        'image',

        'prix',
    ];

    // Relation : un article appartient à une catégorie
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'category_id', 'id_categorie');
    }

    // Relation : un article peut exister dans plusieurs lignes de commande
    public function lignesCommande()
    {
        return $this->hasMany(LigneCommande::class, 'article_reference', 'ref_article');
    }

   public function histories()
    {
        return $this->hasMany(History::class, 'article_reference', 'ref_article');
    }
public function movements()
{
    return $this->hasMany(StockMovement::class, 'article_id', 'id_article')
                ->orderBy('created_at', 'desc');
}

    public $timestamps = true;
}
