<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categorie;           // ta catégorie d’articles (à adapter)
use App\Models\Immobilier\EquipmentCategory;

class Convention extends Model
{
    protected $fillable = [
        'fournisseur_id',
        'reference',
        'annee',
        'date_debut',
        'date_fin',
        'statut',
        'notes',
        'scope',                 // 'stock' ou 'equipment'
        'stock_category_id',
        'equipment_category_id',
    ];


    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class, 'fournisseur_id', 'id_fournisseur');
    }

    public function lignes()
    {
        return $this->hasMany(ConventionArticle::class);
    }

    public function receptions()
    {
        return $this->hasMany(Reception::class, 'convention_id', 'id');
    }

    // 🔹 Catégorie d’articles de stock
    public function stockCategory()
    {
        return $this->belongsTo(Categorie::class, 'stock_category_id', 'id_categorie');
    }

    // 🔹 Catégorie d’équipements biomédicaux
    public function equipmentCategory()
    {
        return $this->belongsTo(EquipmentCategory::class, 'equipment_category_id');
    }

    // Petit helper pratique
    public function isStockConvention(): bool
    {
        return $this->scope === 'stock';
    }

    public function isEquipmentConvention(): bool
    {
        return $this->scope === 'equipment';
    }
}


