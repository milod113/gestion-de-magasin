<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $primaryKey = 'id_service';

    public $timestamps = false;

    protected $fillable = [
        'service_arab',
        'service_fr',
        'code_service',
    ];

    // Relation: one service has many commandes
    public function commandes()
    {
        return $this->hasMany(Commande::class, 'service_code', 'code_service');
    }
}
