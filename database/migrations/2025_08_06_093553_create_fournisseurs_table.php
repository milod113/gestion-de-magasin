<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fournisseurs', function (Blueprint $table) {
            $table->id('id_fournisseur'); // AUTO_INCREMENT
            $table->string('code_fournisseur')->unique(); // champ unique

            $table->string('sociéte')->nullable();
            $table->string('nom')->nullable();
            $table->string('adresse')->nullable();
            $table->string('ville')->nullable();
            $table->string('télephone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('fax')->nullable();
            $table->string('NIS')->nullable();
            $table->string('NIF')->nullable();
            $table->string('RC')->nullable();
            $table->string('raison_sociale')->nullable(); // renommé pour compatibilité
            $table->string('email', 50)->nullable();
            $table->string('n_compte')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fournisseurs');
    }
};

