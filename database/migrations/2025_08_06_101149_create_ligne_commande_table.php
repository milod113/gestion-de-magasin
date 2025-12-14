<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLigneCommandeTable extends Migration
{
    public function up()
    {
 Schema::create('ligne_commande', function (Blueprint $table) {
    $table->id('id_ligne_commande');
    $table->unsignedBigInteger('commande_id');
    $table->integer('quantité')->nullable();

    $table->foreign('commande_id')
          ->references('id_commande')->on('commandes')
          ->onDelete('cascade')->onUpdate('cascade');

             // FK vers articles.ref_article
            $table->integer('article_reference')->nullable();
            $table->foreign('article_reference')
                  ->references('ref_article')->on('articles')
                  ->onDelete('no action');
});

    }

    public function down()
    {
        Schema::dropIfExists('ligne_commande');
    }
}
