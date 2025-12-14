<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id('id_commande'); // AUTO_INCREMENT
            $table->date('date_commande')->nullable();
            $table->string('service_code')->nullable(); // FK vers services.code_service
            $table->string('ref_commande')->unique();   // UNIQUE index
            $table->integer('etat_commande')->nullable();
            $table->string('type_bon_commande')->nullable();
            $table->string('beneficiare')->nullable();

            // Foreign key vers users
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // FK vers service (code_service)
            $table->foreign('service_code')
                  ->references('code_service')->on('services')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};

