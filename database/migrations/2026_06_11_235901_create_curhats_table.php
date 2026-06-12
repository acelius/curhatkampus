<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('curhats', function (Blueprint $table) {
            $table->id();
            $table->string('kode_curhat')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nim');
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('nomor_hp', 30);
            $table->string('kategori');
            $table->string('lokasi');
            $table->string('judul');
            $table->longText('detail');
            $table->string('lampiran_path')->nullable();
            $table->string('lampiran_original_name')->nullable();
            $table->string('lampiran_mime')->nullable();
            $table->unsignedBigInteger('lampiran_size')->nullable();
            $table->string('status')->default('Menunggu');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curhats');
    }
};