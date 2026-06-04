<?php
namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Models\Prediction;
use App\Models\PredictionDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $nextThreeMatches = Fixture::where('date', '>=', now())
            ->where('actual_team1_goals','=',null)
            ->with(['team1', 'team2'])
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->limit(3)
            ->get();

        $nextThreeAfterThat = Fixture::where('date', '>=', now())
            ->with(['team1', 'team2'])
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->skip(3)
            ->limit(3)
            ->get();

        $predictions = Auth::user()->predictions()->with('fixture')->get();

        $pred = Prediction::where('user_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get(['is_correct']);

        $total_correct_predictions = $pred->count();

        $totalPoints = DB::table('predictions')
            ->leftJoin('prediction_details', 'predictions.id', '=', 'prediction_details.predication_id')
            ->where('predictions.user_id', Auth::id())
            ->select(DB::raw('COALESCE(SUM(predictions.points), 0) + COALESCE(SUM(prediction_details.points), 0) as total_points'))
            ->value('total_points');


        return view('users.dashboard', compact('nextThreeMatches', 'nextThreeAfterThat', 'predictions', 'totalPoints', 'total_correct_predictions'));
    }

    public function update_result()
    {
        $fixtures = Fixture::where('date', '>=', now())
        ->where('actual_team1_goals','=',null)
        ->with(['team1', 'team2'])->get();

        return view('users.update_result', compact('fixtures'));
    }

    public function update_result_store(Request $request)
    {
        $fixture                     = Fixture::find($request->fixture_id);
        $fixture->actual_team1_goals = $request->team1_goals;
        $fixture->actual_team2_goals = $request->team2_goals;

        if ($fixture->actual_team1_goals > $fixture->actual_team2_goals) {
            $fixture->winning_team = $fixture->team1_id;
        } else if ($fixture->actual_team1_goals < $fixture->actual_team2_goals) {
            $fixture->winning_team = $fixture->team2_id;
        } else {
            $fixture->is_draw = 1;
        }

        $fixture->save();

        $predictions = Prediction::where('fixture_id', $request->fixture_id)->get();

        foreach ($predictions as $prediction) {
            if ($fixture->winning_team == $prediction->winning_team) {
                $prediction->is_correct = 1;
                $prediction->points     = 5;

            } else if ($prediction->is_draw == $fixture->is_draw) {
                $prediction->is_correct = 1;
                $prediction->points     = 5;
            } else {
                $prediction->is_correct = 0;
                $prediction->points     = 0;
            }
            $prediction->save();

            $predictionDetails = PredictionDetails::where('predication_id', $prediction->id)->get();
            foreach ($predictionDetails as $predictionDetail) {
                if (($predictionDetail->team1_goals == $fixture->actual_team1_goals) && ($predictionDetail->team2_goals == $fixture->actual_team2_goals)) {
                    $predictionDetail->is_correct = 1;
                    $predictionDetail->points     = 5;
                } else {
                    $predictionDetail->is_correct = 0;
                    $predictionDetail->points     = 0;

                }
                $predictionDetail->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Final result saved successfully',
        ]);
    }

    public function leaderboard()
    {
        // Implementation for leaderboard view
        return view('users.leaderboard');
    }

    public function analytics()
    {
        // Implementation for analytics view
        return view('users.analytics');
    }

}
