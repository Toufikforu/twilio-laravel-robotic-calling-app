<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('call_leads', function (Blueprint $table) {
            $table->foreignId('campaign_id')->nullable()
                ->after('id')
                ->constrained('campaigns')
                ->nullOnDelete();

            $table->index('campaign_id');
        });
    }

    public function down(): void
    {
        Schema::table('call_leads', function (Blueprint $table) {
            $table->dropConstrainedForeignId('campaign_id');
        });
    }
};