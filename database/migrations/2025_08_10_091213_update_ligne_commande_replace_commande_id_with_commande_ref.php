<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLigneCommandeReplaceCommandeIdWithCommandeRef extends Migration
{
    public function up()
    {
        Schema::table('ligne_commande', function (Blueprint $table) {
            // 1️⃣ Drop foreign key and column for commande_id
            $table->dropForeign(['commande_id']);
            $table->dropColumn('commande_id');

            // 2️⃣ Add commande_ref column
            $table->string('commande_ref'); // adjust type/length to match commandes.ref_commande

            // 3️⃣ Add foreign key to commandes.ref_commande
            $table->foreign('commande_ref')
                  ->references('ref_commande')
                  ->on('commandes')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::table('ligne_commande', function (Blueprint $table) {
            // Rollback: drop commande_ref
            $table->dropForeign(['commande_ref']);
            $table->dropColumn('commande_ref');

            // Restore commande_id
            $table->unsignedBigInteger('commande_id');

            $table->foreign('commande_id')
                  ->references('id_commande')
                  ->on('commandes')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }
}
