<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLigneLivraisonTable extends Migration
{
    public function up()
    {
        Schema::create('ligne_livraison', function (Blueprint $table) {
            $table->increments('id_ligne_livraison');

            // Clé étrangère vers livraisons
            $table->unsignedBigInteger('id_livraison_1')->nullable();
            $table->foreign('id_livraison_1')
                  ->references('id_livraison')
                  ->on('livraisons')
                  ->onDelete('no action');

            // Quantité livrée
            $table->integer('quantité_livré')->nullable();

            // Clé étrangère vers articles
            $table->integer('artc_ref')->nullable(); // Doit correspondre au type de ref_article
            $table->foreign('artc_ref')
                  ->references('ref_article')
                  ->on('articles') // Correction ici
                  ->onDelete('no action');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ligne_livraison');
    }
}
