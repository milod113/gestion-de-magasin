<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('conventions', function (Blueprint $table) {
            // scope: example text describing convention scope
            $table->string('scope')->nullable()->after('notes');

            // single category_id FK (adjust column/table names to yours)
            $table->unsignedBigInteger('category_id')->nullable()->after('scope');

            $table->foreign('category_id')
                  ->references('id_categorie')
                  ->on('categories')
                  ->nullOnDelete(); // if category deleted, set null
        });
    }

    public function down(): void
    {
        Schema::table('conventions', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['scope', 'category_id']);
        });
    }
};
