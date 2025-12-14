<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $primaryKey = 'id_categorie';

    protected $fillable = [
        'designation',
         'description',
        'image',

    ];

    public $timestamps = false; // Car il n'y a pas de created_at / updated_at dans ta table

    // Relation : une catégorie a plusieurs articles
    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id', 'id_categorie');
    }
}
