<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $fillable = [
        'article_id',
        'type',
        'quantite',
        'stock_avant',
        'stock_apres',
        'source',
        'reference',
        'user_id',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id', 'id_article');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
