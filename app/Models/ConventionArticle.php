<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Article;
use App\Models\Immobilier\Equipment;

class ConventionArticle extends Model
{
    protected $fillable = [
        'convention_id',
        'item_type',           // 'article' ou 'equipment'
        'article_id',          // pour les articles de stock
        'equipment_id',        // pour les équipements biomédicaux
        'quantite_convenue',
        'prix_convenu',
        'unite',
    ];

    public function convention()
    {
        return $this->belongsTo(Convention::class);
    }

    // 🔹 Article de stock (habillement, literie, consommables...)
    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id', 'id_article');
    }

    // 🔹 Equipement biomédical / immobilier (Immobilier\Equipment)
    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }

    // Helpers pratiques

    public function isStockLine(): bool
    {
        return $this->item_type === 'article';
    }

    public function isEquipmentLine(): bool
    {
        return $this->item_type === 'equipment';
    }

    public function getDisplayLabelAttribute(): ?string
    {
        if ($this->isStockLine()) {
            return $this->article?->designation;
        }

        return $this->equipment?->label;
    }

    public function getDisplayReferenceAttribute(): ?string
    {
        if ($this->isStockLine()) {
            return $this->article?->ref_article;
        }

        // Pour l’équipement tu peux utiliser modèle, référence interne, etc.
        return $this->equipment?->model ?? $this->equipment?->label;
    }
}


