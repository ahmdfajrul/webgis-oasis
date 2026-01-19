<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tanaman', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pohon');
            $table->string('nama_pohon');
            $table->string('nama_latin');
            $table->year('tahun_tanam');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('foto_pohon');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tanaman');
    }
};
