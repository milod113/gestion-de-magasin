<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();

            // Identifiant interne (optionnel, mais souvent utilisé)
            $table->string('inventory_number')->nullable()->unique();

            // Numéro de série constructeur : chaque appareil est unique par ce champ
            $table->string('serial_number')->unique();

            // Catégorie (respirateur, moniteur, etc.)
            $table->foreignId('equipment_category_id')
                  ->constrained('equipment_categories')
                  ->cascadeOnDelete();

            // Quelques infos de base (le reste viendra plus tard : localisation, contrats...)
            $table->string('label')->nullable();   // Nom lisible : "Respirateur Dräger Evita 4"
            $table->string('manufacturer')->nullable(); // Constructeur
            $table->string('model')->nullable();   // Modèle constructeur (texte simple pour l’instant)

            $table->date('acquisition_date')->nullable();
            $table->decimal('purchase_price', 15, 2)->nullable();

            // Statut de l’appareil
            $table->string('status')->default('en_service');
            // ex: en_service, en_panne, en_maintenance, hors_service

            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes(); // si tu veux pouvoir "supprimer" sans perdre l’historique
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};

