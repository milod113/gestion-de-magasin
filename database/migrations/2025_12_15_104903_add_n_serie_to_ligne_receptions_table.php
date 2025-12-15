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
        $table->string('n_serie')->nullable()->after('reference_BL');
        // optionnel: index si tu recherches souvent
        // $table->index('n_serie');
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
