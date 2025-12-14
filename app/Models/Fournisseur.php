<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    protected $primaryKey = 'id_fournisseur';

    public $timestamps = false;

    protected $fillable = [
        'code_fournisseur',
        'sociéte',
        'nom',
        'adresse',
        'ville',
        'télephone',
        'mobile',
        'fax',
        'NIS',
        'NIF',
        'RC',
        'raison_sociale',
        'email',
        'n_compte',
    ];
        public function receptions()
    {
        return $this->hasMany(Reception::class, 'fournisseur_id', 'id_fournisseur');
    }
}
