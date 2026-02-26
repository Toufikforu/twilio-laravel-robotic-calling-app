<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('script_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->string('status')->default('draft'); // draft, running, stopped, completed

            // basic stats (optional but helpful for UI)
            $table->unsignedInteger('total_leads')->default(0);
            $table->unsignedInteger('queued_leads')->default(0);
            $table->unsignedInteger('completed_leads')->default(0);
            $table->unsignedInteger('failed_leads')->default(0);

            $table->timestamp('started_at')->nullable();
            $table->timestamp('stopped_at')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};