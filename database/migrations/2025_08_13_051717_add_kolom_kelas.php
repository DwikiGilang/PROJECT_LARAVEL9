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
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->string('kelas')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     * mengembalikan table ke state sebelumnya
     */
    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropColumn('kelas');
        });
    }
};
