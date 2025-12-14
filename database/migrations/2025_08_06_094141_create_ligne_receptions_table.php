<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ligne_receptions', function (Blueprint $table) {
            $table->id('id_ligne_reception');

            // FK vers receptions.id_reception
            $table->unsignedBigInteger('reception_id')->nullable();
            $table->foreign('reception_id')
                  ->references('id_reception')->on('receptions')
                  ->onDelete('no action');

            // FK vers articles.ref_article
            $table->integer('article_reference')->nullable();
            $table->foreign('article_reference')
                  ->references('ref_article')->on('articles')
                  ->onDelete('no action');

            $table->integer('quantité')->nullable();
            $table->string('reference_BL')->nullable();
            $table->decimal('prix_unitaire', 10, 0)->nullable();
            $table->decimal('sous_total', 10, 0)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ligne_receptions');
    }
};

