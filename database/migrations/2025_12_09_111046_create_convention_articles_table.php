<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConventionArticlesTable extends Migration
{
    public function up()
    {
        Schema::create('convention_articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('convention_id');
            $table->unsignedBigInteger('article_id');
            $table->integer('quantite_convenue')->nullable();   // quantité prévue / plafond
            $table->decimal('prix_convenu', 15, 2);             // prix unitaire
            $table->string('unite')->nullable();                // ex: "PCS", "KG"
            $table->timestamps();

            $table->foreign('convention_id')
                  ->references('id')
                  ->on('conventions')
                  ->onDelete('cascade');

            $table->foreign('article_id')
                  ->references('id_article')    // adapte au nom de ta PK
                  ->on('articles')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('convention_articles');
    }
}

