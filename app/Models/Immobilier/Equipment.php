<?php

namespace App\Models\Immobilier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use SoftDeletes;

    protected $table = 'equipment';

    /**
     * Ici, on considère Equipment comme le "modèle" d'équipement
     * (ex : Scanner Siemens 64 barrettes).
     *
     * Les champs propres à chaque exemplaire physique (num inventaire, num série, etc.)
     * doivent aller dans la table equipment_units.
     */
    protected $fillable = [
        'equipment_category_id',
        'label',
        'manufacturer',
        'model',
        'status',            
        'notes',
    ];

 

    /**
     * Un équipement (modèle) appartient à une catégorie.
     */
    public function category()
    {
        return $this->belongsTo(EquipmentCategory::class, 'equipment_category_id');
    }

    /**
     * Un équipement (modèle) possède plusieurs exemplaires physiques (units).
     */
    public function units()
    {
        return $this->hasMany(EquipmentUnit::class, 'equipment_id');
    }
}
