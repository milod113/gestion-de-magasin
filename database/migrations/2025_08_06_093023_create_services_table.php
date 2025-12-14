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
        Schema::create('services', function (Blueprint $table) {
            $table->id('id_service'); // auto-increment
            $table->string('service_arab')->nullable();
            $table->string('service_fr')->nullable();
            $table->string('code_service')->unique(); // unique + index
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
