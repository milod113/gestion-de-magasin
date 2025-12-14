<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livraison extends Model
{
    use HasFactory;

    protected $table = 'livraisons';

    protected $primaryKey = 'id_livraison';

    public $timestamps = false;

    protected $fillable = [
        'commande_ref',
        'date_livraison',
        'livré_par',
        'etat_livraison',
        'user_id',
    ];
protected $casts = [
    'date_livraison' => 'datetime',
];
    // Relation avec l'utilisateur qui a livré
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec la commande (par ref_commande)
    public function commande()
    {
        return $this->belongsTo(Commande::class, 'commande_ref', 'ref_commande');
    }

    // Optionnel : relation avec les lignes de livraison
    public function lignes()
    {
        return $this->hasMany(LigneLivraison::class, 'id_livraison_1', 'id_livraison');
    }
}
