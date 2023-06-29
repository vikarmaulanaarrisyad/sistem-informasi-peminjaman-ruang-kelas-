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
        Schema::table('dosen_matakuliah', function (Blueprint $table) {
            $table->foreign('dosen_id')
                ->references('id')
                ->on('dosen')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('matakuliah_id')
                ->references('id')
                ->on('matakuliah')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dosen_matakuliah', function (Blueprint $table) {
            $table->dropForeign('dosen_matakuliah_dosen_id_foreign');
            $table->dropForeign('dosen_matakuliah_matakuliah_id_foreign');
        });
    }
};
