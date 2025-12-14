<?php

// app/Models/Immobilier/EquipmentUnit.php

namespace App\Models\Immobilier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentUnit extends Model
{
    use SoftDeletes;

    protected $table = 'equipment_units';

    protected $fillable = [
        'equipment_id',
        'inventory_number',
        'serial_number',
        'acquisition_date',
        'code',
        'purchase_price',
        'status',
        'notes',
    ];

    protected $casts = [
        'acquisition_date' => 'date',
        'purchase_price'   => 'decimal:2',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }
}

