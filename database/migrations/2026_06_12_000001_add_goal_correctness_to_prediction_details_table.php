<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prediction_details', function (Blueprint $table) {
            $table->boolean('team1_goal_correct')->nullable()->after('team2_goals');
            $table->boolean('team2_goal_correct')->nullable()->after('team1_goal_correct');
        });
    }

    public function down(): void
    {
        Schema::table('prediction_details', function (Blueprint $table) {
            $table->dropColumn(['team1_goal_correct', 'team2_goal_correct']);
        });
    }
};
