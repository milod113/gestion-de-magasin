<?php

// php artisan make:migration create_equipment_units_table

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('equipment_units', function (Blueprint $table) {
            $table->id();

            // 🔗 lien vers le modèle d'équipement
            $table->unsignedBigInteger('equipment_id');
            $table->foreign('equipment_id')
                ->references('id')->on('equipment')
                ->onDelete('cascade');

            // 👇 infos propres à CHAQUE exemplaire physique
            $table->string('inventory_number')->unique();
            $table->string('serial_number')->nullable()->unique();
            $table->string('code')->nullable()->unique();


            $table->date('acquisition_date')->nullable();
            $table->decimal('purchase_price', 15, 2)->nullable();
            $table->string('status')->nullable(); // ex: 'actif', 'en panne', etc.
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment_units');
    }
};

