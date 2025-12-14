<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reception extends Model
{
    protected $primaryKey = 'id_reception';

    protected $fillable = [
        'convention_id',
        'date_reception',
        'user_id',
        'Total',
        'reception_reference',
        'etat_reception',
        'type_reception',
    ];

    protected $casts = [
        'date_reception' => 'datetime',
    ];

    public $timestamps = true;

    // ✅ Reception belongs to Convention
    public function convention()
    {
        return $this->belongsTo(Convention::class, 'convention_id', 'id');
    }

    // ✅ Keep user relation
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lignes()
    {
        return $this->hasMany(LigneReception::class, 'reception_id', 'id_reception');
    }

    // ✅ Optional convenience: access fournisseur through convention
    public function fournisseur()
    {
        return $this->hasOneThrough(
            Fournisseur::class,
            Convention::class,
            'id_convention',     // FK on conventions
            'code_fournisseur',  // PK on fournisseurs
            'convention_id',     // FK on receptions
            'fournisseur_code'   // FK on conventions referencing fournisseurs
        );
    }
}
