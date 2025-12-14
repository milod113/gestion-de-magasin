<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('receptions', function (Blueprint $table) {
            // drop FK first (name may differ in your DB)
            $table->dropForeign(['fournisseur_code']);
            $table->dropColumn('fournisseur_code');
        });
    }

    public function down(): void
    {
        Schema::table('receptions', function (Blueprint $table) {
            $table->string('fournisseur_code', 255)->nullable();

            $table->foreign('fournisseur_code')
                  ->references('code_fournisseur')
                  ->on('fournisseurs')
                  ->nullOnDelete();
        });
    }
};
