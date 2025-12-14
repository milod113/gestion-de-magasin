<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id('id_article'); // AUTO_INCREMENT
            $table->integer('ref_article')->unique(); // UNIQUE INDEX

            $table->string('designation')->nullable();
            $table->integer('quantite_en_stock')->nullable();
            
            // Clé étrangère vers categorie
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')
                  ->references('id_categorie')
                  ->on('categories')
                  ->onDelete('no action'); // équivalent SQL

            $table->string('unité')->nullable();
            $table->decimal('prix', 10, 2)->nullable();

            // Optionnel : pour suivre les créations/modifications
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};

