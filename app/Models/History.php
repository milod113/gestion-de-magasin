<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class History extends Model
{
        protected $table = 'history';

    protected $primaryKey = 'id_history';
    public $timestamps = false; // car on a date_changement manuelle
    protected $fillable = ['article_reference', 'prix', 'quantite', 'date_changement', 'type_mouvement', 'description'];

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_reference', 'ref_article');
    }
}

