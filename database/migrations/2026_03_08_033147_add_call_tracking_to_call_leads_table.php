<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('call_leads', function (Blueprint $table) {
            $table->string('call_sid')->nullable()->after('status');
            $table->integer('duration')->nullable()->after('call_sid');
        });
    }

    public function down(): void
    {
        Schema::table('call_leads', function (Blueprint $table) {
            $table->dropColumn(['call_sid', 'duration']);
        });
    }
};
