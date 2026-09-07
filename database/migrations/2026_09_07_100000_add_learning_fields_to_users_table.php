<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('preferred_translation', 8)->default('hy')->after('remember_token');
            $table->unsignedTinyInteger('daily_goal')->default(20)->after('preferred_translation');
            $table->unsignedInteger('streak_days')->default(0)->after('daily_goal');
            $table->date('last_study_date')->nullable()->after('streak_days');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['preferred_translation', 'daily_goal', 'streak_days', 'last_study_date']);
        });
    }
};
