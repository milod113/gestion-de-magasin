<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneCommande extends Model
{
    protected $primaryKey = 'id_ligne_commande';
    protected $table = 'ligne_commande'; // 👈 explicitly set table name

    public $timestamps = false;

    protected $fillable = [
        'commande_ref',
        'article_reference',
        'quantité',
    ];

    // Relation: ligne commande belongs to commande
    public function commande()
    {
        return $this->belongsTo(Commande::class, 'commande_ref', 'ref_commande');
    }

    // Relation: ligne commande belongs to article
    public function article()
    {
        return $this->belongsTo(Article::class, 'article_reference', 'ref_article');
    }
}
