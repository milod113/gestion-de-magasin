<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneReception extends Model
{
    protected $primaryKey = 'id_ligne_reception';

    protected $fillable = [
        'reception_id',
        'article_reference',
        'quantité',
        'reference_BL',
        'prix_unitaire',
        'sous_total',
    ];

    public $timestamps = false;

    // Relation avec la réception
    public function reception()
    {
        return $this->belongsTo(Reception::class, 'reception_id', 'id_reception');
    }

    // Relation avec l'article
    public function article()
    {
        return $this->belongsTo(Article::class, 'article_reference', 'ref_article');
    }
}
