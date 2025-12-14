<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('convention_articles', function (Blueprint $table) {
            // drop l'ancienne FK
            $table->dropForeign('convention_articles_article_id_foreign');
        });

        Schema::table('convention_articles', function (Blueprint $table) {
            // rendre nullable
            $table->unsignedBigInteger('article_id')->nullable()->change();

            // recréer la FK (avec SET NULL ou CASCADE au choix)
            $table->foreign('article_id')
                  ->references('id_article')->on('articles')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('convention_articles', function (Blueprint $table) {
            $table->dropForeign('convention_articles_article_id_foreign');
        });

        Schema::table('convention_articles', function (Blueprint $table) {
            $table->unsignedBigInteger('article_id')->nullable(false)->change();

            $table->foreign('article_id')
                  ->references('id_article')->on('articles')
                  ->onDelete('cascade');
        });
    }
};
