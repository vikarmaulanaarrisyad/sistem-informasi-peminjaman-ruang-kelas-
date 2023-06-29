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
        Schema::table('kelas_mahasiswa', function (Blueprint $table) {
            $table->foreign('kelas_id')
                ->references('id')
                ->on('kelas')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('mahasiswa_id')
                ->references('id')
                ->on('mahasiswa')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas_mahasiswa', function (Blueprint $table) {
            $table->dropForeign('kelas_mahasiswa_kelas_id_foreign');
            $table->dropForeign('kelas_mahasiswa_mahasiswa_id_foreign');
        });
    }
};
