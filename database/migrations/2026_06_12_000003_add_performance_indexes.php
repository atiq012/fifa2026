<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private function hasIndex(string $table, string $keyName): bool
    {
        return collect(DB::select("SHOW INDEX FROM `{$table}` WHERE Key_name = ?", [$keyName]))->isNotEmpty();
    }

    public function up(): void
    {
        // fixtures
        Schema::table('fixtures', function (Blueprint $table) {
            if (!$this->hasIndex('fixtures', 'idx_fixtures_goals_date')) {
                $table->index(['actual_team1_goals', 'date'], 'idx_fixtures_goals_date');
            }
            if (!$this->hasIndex('fixtures', 'idx_fixtures_team1')) {
                $table->index('team1_id', 'idx_fixtures_team1');
            }
            if (!$this->hasIndex('fixtures', 'idx_fixtures_team2')) {
                $table->index('team2_id', 'idx_fixtures_team2');
            }
        });

        // teams
        Schema::table('teams', function (Blueprint $table) {
            if (!$this->hasIndex('teams', 'idx_teams_group_name')) {
                $table->index(['group', 'name'], 'idx_teams_group_name');
            }
            if (!$this->hasIndex('teams', 'idx_teams_name')) {
                $table->index('name', 'idx_teams_name');
            }
        });

        // predictions
        Schema::table('predictions', function (Blueprint $table) {
            if (!$this->hasIndex('predictions', 'uq_predictions_user_fixture')) {
                $table->unique(['user_id', 'fixture_id'], 'uq_predictions_user_fixture');
            }
            if (!$this->hasIndex('predictions', 'idx_predictions_fixture')) {
                $table->index('fixture_id', 'idx_predictions_fixture');
            }
            if (!$this->hasIndex('predictions', 'idx_predictions_correct_created')) {
                $table->index(['is_correct', 'created_at'], 'idx_predictions_correct_created');
            }
        });

        // prediction_details
        Schema::table('prediction_details', function (Blueprint $table) {
            if (!$this->hasIndex('prediction_details', 'idx_pred_details_prediction')) {
                $table->index('predication_id', 'idx_pred_details_prediction');
            }
        });

        // my_teams
        Schema::table('my_teams', function (Blueprint $table) {
            if (!$this->hasIndex('my_teams', 'uq_my_teams_user')) {
                $table->unique('user_id', 'uq_my_teams_user');
            }
        });
    }

    public function down(): void
    {
        Schema::table('fixtures', function (Blueprint $table) {
            if ($this->hasIndex('fixtures', 'idx_fixtures_goals_date')) {
                $table->dropIndex('idx_fixtures_goals_date');
            }
            if ($this->hasIndex('fixtures', 'idx_fixtures_team1')) {
                $table->dropIndex('idx_fixtures_team1');
            }
            if ($this->hasIndex('fixtures', 'idx_fixtures_team2')) {
                $table->dropIndex('idx_fixtures_team2');
            }
        });

        Schema::table('teams', function (Blueprint $table) {
            if ($this->hasIndex('teams', 'idx_teams_group_name')) {
                $table->dropIndex('idx_teams_group_name');
            }
            if ($this->hasIndex('teams', 'idx_teams_name')) {
                $table->dropIndex('idx_teams_name');
            }
        });

        Schema::table('predictions', function (Blueprint $table) {
            if ($this->hasIndex('predictions', 'uq_predictions_user_fixture')) {
                $table->dropUnique('uq_predictions_user_fixture');
            }
            if ($this->hasIndex('predictions', 'idx_predictions_fixture')) {
                $table->dropIndex('idx_predictions_fixture');
            }
            if ($this->hasIndex('predictions', 'idx_predictions_correct_created')) {
                $table->dropIndex('idx_predictions_correct_created');
            }
        });

        Schema::table('prediction_details', function (Blueprint $table) {
            if ($this->hasIndex('prediction_details', 'idx_pred_details_prediction')) {
                $table->dropIndex('idx_pred_details_prediction');
            }
        });

        Schema::table('my_teams', function (Blueprint $table) {
            if ($this->hasIndex('my_teams', 'uq_my_teams_user')) {
                $table->dropUnique('uq_my_teams_user');
            }
        });
    }
};
