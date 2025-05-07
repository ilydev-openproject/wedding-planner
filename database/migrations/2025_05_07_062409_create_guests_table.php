<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('wedding_id')->constrained()->onDelete('cascade'); // relasi ke tabel weddings
            $table->string('name');             // nama tamu
            $table->string('phone')->nullable(); // nomor HP (jika ingin pakai WhatsApp)
            $table->enum('status', ['pending', 'confirmed', 'declined'])->default('pending'); // status RSVP
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
