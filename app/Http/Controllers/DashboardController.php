<?php
namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Models\MyTeam;
use App\Models\Prediction;
use App\Models\PredictionDetails;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $nextThreeMatches = Fixture::where('date', '>=', now())
            ->where('actual_team1_goals', '=', null)
            ->with(['team1', 'team2'])
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->limit(3)
            ->get();

        // $nextThreeMatches = Fixture::upcoming()
        //     ->with(['team1', 'team2'])
        //     ->orderBy('date', 'asc')
        //     ->orderByRaw("STR_TO_DATE(time, '%h:%i %p') asc")
        //     ->limit(3)
        //     ->get();

        $predictions = Auth::user()->predictions()->with('fixture')->get();

        $pred = Prediction::where('user_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get(['is_correct']);

        $total_correct_predictions = $pred->where('is_correct', '1')->count();

        $totalPoints = DB::table('predictions')
            ->leftJoin('prediction_details', 'predictions.id', '=', 'prediction_details.predication_id')
            ->where('predictions.user_id', Auth::id())
            ->select(DB::raw('COALESCE(SUM(predictions.points), 0) + COALESCE(SUM(prediction_details.points), 0) as total_points'))
            ->value('total_points');

        $favorite_team = MyTeam::where('user_id', Auth::id())->first();

        $teams = Team::orderBy('group', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        $players = DB::table('v_emp_info')->where('emp_status', 'Active')->select('id', 'full_name', 'depart_name')->get();

        // In your controller
        $allPred = Prediction::where('is_correct', null)
            ->with(['fixture.team1', 'fixture.team2'])
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy('fixture_id')
            ->map(function ($predictions) {
                return $predictions->first(); // Take first prediction for each fixture
            });
        $myPr = $allPred->pluck('fixture_id');

        return view('users.dashboard', compact('myPr', 'nextThreeMatches', 'predictions', 'totalPoints', 'total_correct_predictions', 'teams', 'favorite_team', 'players', 'allPred'));
    }

    public function saveMyteam(Request $request)
    {
        $myTeam = new MyTeam();

        $myTeam->team_id    = $request->team;
        $myTeam->user_id    = Auth::user()->id;
        $myTeam->created_by = Auth::user()->id;
        $myTeam->save();

        return response()->json([
            'success' => true,
            'message' => 'Final result saved successfully',
        ]);
    }

    public function update_result()
    {
        $fixtures = Fixture::where('date', '>=', now())
            ->where('actual_team1_goals', '=', null)
            ->with(['team1', 'team2'])->get();
        $favorite_team = MyTeam::where('user_id', Auth::id())->first();

        return view('users.update_result', compact('fixtures', 'favorite_team'));
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
        $favorite_team = MyTeam::where('user_id', Auth::id())->first();
        $players       = DB::table('v_emp_info')->where('emp_status', 'Active')->select('id', 'full_name', 'depart_name', 'emp_code')->get();

        // Implementation for leaderboard view
        return view('users.leaderboard', compact('favorite_team', 'players'));
    }

    public function analytics()
    {
        $favorite_team = MyTeam::where('user_id', Auth::id())->first();

        // Implementation for analytics view
        return view('users.analytics', compact('favorite_team'));
    }

}
