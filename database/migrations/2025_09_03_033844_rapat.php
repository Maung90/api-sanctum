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
        Schema::create('rapats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->string('judul');
            $table->dateTime('waktu');
            $table->string('lokasi')->nullable();
            $table->text('agenda')->nullable();
            $table->enum('status', ['draft', 'ongoing', 'selesai'])->default('draft');
            $table->string('passcode')->nullable();
            $table->string('qr')->nullable();
            $table->longText('notulensi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapats');
    }
};
