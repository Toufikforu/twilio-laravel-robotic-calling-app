<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('call_leads', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone'); // store E.164 ideally

            $table->string('status')->default('pending'); // pending, queued, calling, completed, failed, no_answer
            $table->timestamp('call_date')->nullable();   // when attempted/called

            $table->timestamps();

            $table->index('phone');
            $table->index('status');
            $table->index('call_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('call_leads');
    }
};