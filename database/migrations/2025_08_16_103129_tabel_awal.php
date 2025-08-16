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
        Schema::create('membaca', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('soal_1');
            $table->text('soal_2');
            $table->text('soal_3');
            $table->text('soal_4');
            $table->text('soal_5');
            $table->text('soal_6');
            $table->timestamps();
        });

        Schema::create('menyimak', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('soal_1');
            $table->text('soal_2');
            $table->timestamps();
        });

        Schema::create('menulis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('soal_1');
            $table->timestamps();
        });

        Schema::create('berbicara', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('file_audio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berbicara');
        Schema::dropIfExists('menulis');
        Schema::dropIfExists('menyimak');
        Schema::dropIfExists('membaca');
    }
};
