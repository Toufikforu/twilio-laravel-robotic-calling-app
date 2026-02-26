<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('scripts', function (Blueprint $table) {
            $table->id();

            // Optional: link script to user (recommended for multi-user dashboard)
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('name')->nullable();     // optional label like "GOTV Script"
            $table->text('content');                // the text that will be read via TTS

            $table->timestamps();

            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scripts');
    }
};