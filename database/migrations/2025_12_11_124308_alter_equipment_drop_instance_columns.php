<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            // 1) Supprimer les index uniques
            $table->dropUnique('equipment_inventory_number_unique');
            $table->dropUnique('equipment_serial_number_unique');
        });

        Schema::table('equipment', function (Blueprint $table) {
            // 2) Supprimer les colonnes devenues inutiles
            $table->dropColumn([
                'inventory_number',
                'serial_number',
                'acquisition_date',
                'purchase_price',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            // 1) On recrée les colonnes
            $table->string('inventory_number')->nullable()->unique();
            $table->string('serial_number')->nullable()->unique();
            $table->date('acquisition_date')->nullable();
            $table->decimal('purchase_price', 15, 2)->nullable();
        });

        Schema::table('equipment', function (Blueprint $table) {
            // 2) Re-création explicite des index uniques (optionnel si déjà dans la définition ci-dessus)
            $table->unique('inventory_number', 'equipment_inventory_number_unique');
            $table->unique('serial_number', 'equipment_serial_number_unique');
        });
    }
};
