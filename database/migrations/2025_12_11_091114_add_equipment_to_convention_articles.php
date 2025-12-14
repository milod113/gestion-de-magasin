<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_equipment_to_convention_articles.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEquipmentToConventionArticles extends Migration
{
    public function up()
    {
        Schema::table('convention_articles', function (Blueprint $table) {
            // Type de ligne : 'article' (par défaut) ou 'equipment'
            $table->string('item_type')
                  ->default('article')
                  ->after('id');

            // Référence vers Equipement biomédical (nullable)
            $table->unsignedBigInteger('equipment_id')
                  ->nullable()
                  ->after('article_id');

            $table->foreign('equipment_id')
                  ->references('id')
                  ->on('equipment')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('convention_articles', function (Blueprint $table) {
            $table->dropForeign(['equipment_id']);
            $table->dropColumn(['equipment_id', 'item_type']);
        });
    }
}

