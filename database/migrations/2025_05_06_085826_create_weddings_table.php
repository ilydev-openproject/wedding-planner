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
        Schema::create('weddings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('bride_name');        // nama pengantin wanita
            $table->string('groom_name');        // nama pengantin pria
            $table->string('wedding_title')->nullable(); // tema atau nama acara
            $table->date('wedding_date');        // tanggal acara
            $table->string('venue')->nullable(); // lokasi
            $table->text('notes')->nullable();   // catatan tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weddings');
    }
};
