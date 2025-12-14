
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConventionsTable extends Migration
{
    public function up()
    {
        Schema::create('conventions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fournisseur_id');
            $table->string('reference')->unique();   // ex: "MARCHE-2024-001"
            $table->year('annee');                   // ex: 2024
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->enum('statut', ['brouillon', 'actif', 'clos'])->default('brouillon');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('fournisseur_id')
                  ->references('id_fournisseur')   // adapte au nom de ta PK
                  ->on('fournisseurs')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('conventions');
    }
}
