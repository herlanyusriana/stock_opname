<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('counts', function (Blueprint $table) {
            $table->string('pic_name')->nullable()->after('location_id');
            $table->foreignId('auditor_id')->nullable()->after('user_id')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('counts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('auditor_id');
            $table->dropColumn('pic_name');
        });
    }
};
