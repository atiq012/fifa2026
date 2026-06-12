<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("DROP VIEW IF EXISTS v_leaderboard");

        DB::statement("
            CREATE VIEW v_leaderboard AS
            SELECT
                u.id AS user_id,
                COALESCE(SUM(CAST(p.points AS UNSIGNED)), 0)
                    + COALESCE(SUM(CAST(pd.points AS UNSIGNED)), 0) AS total_points,
                CASE
                    WHEN COUNT(CASE WHEN pd.team1_goal_correct IS NOT NULL THEN 1 END) = 0 THEN 0.0000
                    ELSE ROUND(
                        (
                            SUM(CASE WHEN pd.team1_goal_correct = 1 THEN 1 ELSE 0 END)
                          + SUM(CASE WHEN pd.team2_goal_correct = 1 THEN 1 ELSE 0 END)
                        ) / (COUNT(CASE WHEN pd.team1_goal_correct IS NOT NULL THEN 1 END) * 2.0) * 100,
                        4
                    )
                END AS goal_accuracy,
                RANK() OVER (
                    ORDER BY
                        COALESCE(SUM(CAST(p.points AS UNSIGNED)), 0)
                            + COALESCE(SUM(CAST(pd.points AS UNSIGNED)), 0) DESC,
                        CASE
                            WHEN COUNT(CASE WHEN pd.team1_goal_correct IS NOT NULL THEN 1 END) = 0 THEN 0.0000
                            ELSE ROUND(
                                (
                                    SUM(CASE WHEN pd.team1_goal_correct = 1 THEN 1 ELSE 0 END)
                                  + SUM(CASE WHEN pd.team2_goal_correct = 1 THEN 1 ELSE 0 END)
                                ) / (COUNT(CASE WHEN pd.team1_goal_correct IS NOT NULL THEN 1 END) * 2.0) * 100,
                                4
                            )
                        END DESC
                ) AS ranking
            FROM users u
            LEFT JOIN predictions p ON p.user_id = u.id
            LEFT JOIN prediction_details pd ON pd.predication_id = p.id
            GROUP BY u.id
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS v_leaderboard");
    }
};
