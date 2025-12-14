<?php

namespace App\Models\Immobilier;

use Illuminate\Database\Eloquent\Model;

class EquipmentCategory extends Model
{
    protected $table = 'equipment_categories';

    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    // Une catégorie a plusieurs équipements
    public function equipment()
    {
        return $this->hasMany(Equipment::class, 'equipment_category_id');
    }
}
