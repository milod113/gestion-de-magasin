<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('receptions', function (Blueprint $table) {
            $table->bigIncrements('id_reception');
            $table->date('date_reception')->nullable();

            $table->string('fournisseur_code')->nullable(); // FK vers fournisseurs.code_fournisseur

            $table->foreignId('user_id') // reçu par
                  ->constrained()
                  ->onDelete('cascade');

            $table->decimal('Total', 10, 0);
            $table->string('reception_reference');
            $table->integer('etat_reception')->nullable();
            $table->integer('type_reception')->nullable();

            // Clé unique composite
            $table->unique(['id_reception', 'reception_reference']);

            // FK fournisseur
            $table->foreign('fournisseur_code')
                  ->references('code_fournisseur')->on('fournisseurs')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receptions');
    }
};
