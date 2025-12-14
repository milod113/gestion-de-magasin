<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('receptions', function (Blueprint $table) {
            $table->unsignedBigInteger('convention_id')->nullable()->after('id_reception');

            $table->foreign('convention_id')
                  ->references('id') // adjust if your PK name differs
                  ->on('conventions')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('receptions', function (Blueprint $table) {
            $table->dropForeign(['convention_id']);
            $table->dropColumn('convention_id');
        });
    }
};

