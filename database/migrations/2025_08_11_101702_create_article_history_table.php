<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
   
Schema::create('history', function (Blueprint $table) {
    $table->id('id_history');    
    $table->decimal('prix', 10, 2);       // prix à ce moment-là
    $table->integer('quantite');          // quantité à ce moment-là
    $table->timestamp('date_changement'); // date du changement
    
            $table->integer('article_reference')->nullable();
            $table->foreign('article_reference')
                  ->references('ref_article')->on('articles')
                  ->onDelete('no action');
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_history');
    }
};
