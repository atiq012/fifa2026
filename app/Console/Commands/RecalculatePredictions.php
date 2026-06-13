<?php

namespace App\Console\Commands;

use App\Models\Fixture;
use App\Models\Prediction;
use App\Models\PredictionDetails;
use Illuminate\Console\Command;

class RecalculatePredictions extends Command
{
    protected $signature = 'predictions:recalculate {--fixture= : Specific fixture ID (omit to recalculate all fixtures with results)}';

    protected $description = 'Backfill/recalculate prediction points using tiered scoring (5/2/0 for goals, 5/0 for winner)';

    public function handle(): int
    {
        $fixtureId = $this->option('fixture');

        $query = Fixture::whereNotNull('actual_team1_goals')->with(['team1', 'team2']);

        if ($fixtureId) {
            $query->where('id', $fixtureId);
        }

        $fixtures = $query->get();

        if ($fixtures->isEmpty()) {
            $this->warn('No fixtures with results found.');
            return self::FAILURE;
        }

        foreach ($fixtures as $fixture) {
            $label = "{$fixture->team1->name} vs {$fixture->team2->name} ({$fixture->actual_team1_goals}–{$fixture->actual_team2_goals})";
            $this->info("Processing: {$label}");

            $predictions = Prediction::where('fixture_id', $fixture->id)->get();
            $predCount   = 0;
            $detCount    = 0;

            foreach ($predictions as $prediction) {
                // --- Winner/draw correctness ---
                $winnerCorrect = (
                    ($fixture->winning_team && $fixture->winning_team == $prediction->winning_team) ||
                    ($fixture->is_draw && $prediction->is_draw)
                );

                $prediction->is_correct = $winnerCorrect ? 1 : 0;
                $prediction->points     = $winnerCorrect ? 5 : 0;
                $prediction->save();
                $predCount++;

                // --- Goal detail correctness (tiered 5/2/0) ---
                $details = PredictionDetails::where('predication_id', $prediction->id)->get();

                foreach ($details as $detail) {
                    $t1Correct = ((int) $detail->team1_goals === (int) $fixture->actual_team1_goals);
                    $t2Correct = ((int) $detail->team2_goals === (int) $fixture->actual_team2_goals);

                    $detail->team1_goal_correct = $t1Correct ? 1 : 0;
                    $detail->team2_goal_correct = $t2Correct ? 1 : 0;

                    if ($t1Correct && $t2Correct) {
                        $detail->is_correct = 1;
                        $detail->points     = 5;
                    } elseif ($t1Correct || $t2Correct) {
                        $detail->is_correct = 0;
                        $detail->points     = 2;
                    } else {
                        $detail->is_correct = 0;
                        $detail->points     = 0;
                    }

                    $detail->save();
                    $detCount++;
                }
            }

            $this->line("  → {$predCount} predictions, {$detCount} details updated");
        }

        $this->info('Done.');
        return self::SUCCESS;
    }
}
