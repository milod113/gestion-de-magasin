<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('stock_movements', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('article_id');      // lien vers l’article
        $table->enum('type', ['entree', 'sortie', 'ajustement']); // type de mouvement
        $table->integer('quantite');                   // + ou - (ex: 10 ou -5)
        $table->integer('stock_avant')->nullable();    // optionnel
        $table->integer('stock_apres')->nullable();    // optionnel
        $table->string('source')->nullable();          // ex: 'réception', 'vente', 'inventaire'
        $table->string('reference')->nullable();       // réf document (BL, facture…)
        $table->unsignedBigInteger('user_id')->nullable(); // qui a fait l’opération ?
        $table->timestamps();

        $table->foreign('article_id')
              ->references('id_article')  // adapte si ta clé est différente
              ->on('articles')
              ->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
