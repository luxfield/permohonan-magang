<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('magang_kinerjas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('magang_application_id')->constrained()->onDelete('cascade');
            $table->foreignId('intern_id')->nullable()->constrained('interns')->onDelete('set null');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('magang_kinerjas');
    }
};