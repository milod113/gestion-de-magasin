<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('livraisons', function (Blueprint $table) {
            $table->id('id_livraison'); // AUTO_INCREMENT
            $table->string('commande_ref')->nullable(); // FK vers commande.ref_commande
            $table->date('date_livraison')->nullable();
            $table->string('livré_par')->nullable(); // nom ou texte (facultatif si on a user_id)
            $table->integer('etat_livraison')->nullable();

            // L'utilisateur qui a livré
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Clé étrangère vers commande
            $table->foreign('commande_ref')
                  ->references('ref_commande')->on('commandes')
                  ->onDelete('no action')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livraisons');
    }
};

