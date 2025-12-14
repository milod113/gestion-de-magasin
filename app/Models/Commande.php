<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $primaryKey = 'id_commande';

    public $timestamps = false;

    protected $fillable = [
        'date_commande',
        'service_code',
        'ref_commande',
        'etat_commande',
        'type_bon_commande',
        'beneficiare',
        'user_id',
    ];
protected $casts = [
    'date_commande' => 'datetime',
];
    // Relation: commande belongs to service
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_code', 'code_service');
    }

    // Relation: commande belongs to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation: commande has many lignes de commande
    public function lignes()
    {
        return $this->hasMany(LigneCommande::class, 'commande_ref', 'ref_commande');
    }


    public function livraisons()
{
    return $this->hasMany(Livraison::class, 'commande_ref', 'ref_commande');
}
}
