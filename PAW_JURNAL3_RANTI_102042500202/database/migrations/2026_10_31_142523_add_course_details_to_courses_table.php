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
        Schema::table('courses', function (Blueprint $table) {
            $table->string('kode_mk', 20)->unique();
            $table->string('nama_mk', 255);
            $table->text('deskripsi')->nullable();
            $table->unsignedTinyInteger('sks');
            $table->string('semester', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropUnique(['kode_mk']);

            $table->dropColumn([
                'kode_mk',
                'nama_mk',
                'deskripsi',
                'sks',
                'semester',
            ]);
        });
    }
};
