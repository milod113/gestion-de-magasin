<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LigneLivraison extends Model
{
    use HasFactory;

    protected $table = 'ligne_livraison';

    protected $primaryKey = 'id_ligne_livraison';

    public $timestamps = false;

    protected $fillable = [
        'id_livraison_1',
        'quantité_livré',
        'artc_ref',
    ];

    // Relation avec la livraison
    public function livraison()
    {
        return $this->belongsTo(Livraison::class, 'id_livraison_1', 'id_livraison');
    }

    // Relation avec l'article
    public function article()
    {
        return $this->belongsTo(Article::class, 'artc_ref', 'ref_article');
    }
}
