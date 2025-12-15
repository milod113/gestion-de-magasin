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
    Schema::table('ligne_receptions', function (Blueprint $table) {
        $table->nullableMorphs('item'); // ajoute item_type + item_id
        // si tu gardes article_reference, laisse-la. Sinon tu peux la rendre nullable:
        // $table->string('article_reference')->nullable()->change();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ligne_receptions', function (Blueprint $table) {
            //
        });
    }
};
