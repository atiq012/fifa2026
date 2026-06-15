<?php
namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Models\MyTeam;
use App\Models\Prediction;
use App\Models\PredictionDetails;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $nextThreeMatches = Fixture::where('date', '>=', now()->setTimezone('Asia/Dhaka')->startOfDay())
            ->where('date', '<=', now()->setTimezone('Asia/Dhaka')->addDays(2))
            ->where('actual_team1_goals', '=', null)
            ->with(['team1', 'team2'])
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            // ->limit(5)
            ->get();
        // dd($nextThreeMatches);
        // $nextThreeMatches = Fixture::where(function ($query) {
        //     $query->where('date', '>', now()->toDateString()) // Future dates
        //         ->orWhere(function ($query) {
        //             $query->where('date', '=', now()->toDateString()) // Today's date
        //                 ->where('time', '>', now()->format('h:i A'));     // But time is in the future
        //         });
        // })
        //     ->where('actual_team1_goals', '=', null)
        //     ->with(['team1', 'team2'])
        //     ->orderBy('date', 'asc')
        //     ->orderBy('time', 'asc')
        //     ->limit(3)
        //     ->get();

        // $nextThreeMatches = Fixture::upcomings()
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

        // Top 3 for dashboard standings
        $top3 = DB::table('v_emp_info')
            ->where('v_emp_info.emp_status', 'Active')
            ->join('users', 'users.staff_id', '=', 'v_emp_info.emp_code')
            ->leftJoin('emps', 'emps.id', '=', 'users.emp_id')
            ->leftJoin('v_leaderboard', 'v_leaderboard.user_id', '=', 'users.id')
            ->leftJoin('my_teams', 'my_teams.user_id', '=', 'users.id')
            ->leftJoin('teams', 'teams.id', '=', 'my_teams.team_id')
            ->select(
                'v_emp_info.full_name',
                'v_emp_info.depart_name',
                'users.id as user_id',
                'emps.image_path',
                DB::raw('COALESCE(v_leaderboard.total_points, 0) as total_points'),
                DB::raw('COALESCE(v_leaderboard.goal_accuracy, 0) as goal_accuracy'),
                DB::raw('COALESCE(v_leaderboard.ranking, 0) as ranking'),
                'teams.name as team_name',
                'teams.flag as team_flag'
            )
            ->orderBy('total_points', 'desc')
            ->orderBy('goal_accuracy', 'desc')
            ->limit(3)
            ->get();

        // My leaderboard stats
        $myLeaderboard = DB::table('v_leaderboard')
            ->where('user_id', Auth::id())
            ->first();

        $myRank     = $myLeaderboard->ranking ?? '--';
        $myAccuracy = $myLeaderboard ? (float) $myLeaderboard->goal_accuracy : 0;

        // Total predictions submitted
        $totalPredictions = Prediction::where('user_id', Auth::id())->count();

        // Current win streak (consecutive correct from most recent)
        $recentPredictions = Prediction::where('user_id', Auth::id())
            ->whereNotNull('is_correct')
            ->orderByDesc('created_at')
            ->pluck('is_correct');

        $myStreak = 0;
        foreach ($recentPredictions as $correct) {
            if ((int) $correct === 1) {
                $myStreak++;
            } else {
                break;
            }
        }

        // In your controller
        $allPred = Prediction::where('is_correct', null)
            ->with(['fixture.team1', 'fixture.team2'])
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy('fixture_id')
            ->map(function ($predictions) {
                return $predictions->first();
            });

        $myPr = Prediction::where('is_correct', null)
            ->where('user_id', Auth::id())
            ->pluck('fixture_id')
            ->map(fn($id) => (int) $id)
            ->unique();



        return view('users.dashboard', compact('myPr', 'nextThreeMatches', 'predictions', 'totalPoints', 'total_correct_predictions', 'teams', 'favorite_team', 'allPred', 'top3', 'myRank', 'myAccuracy', 'myStreak', 'totalPredictions', 'pred'));
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
        $fixtures = Fixture::where('actual_team1_goals', '=', null)
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
            $fixture->is_draw      = null;
        } elseif ($fixture->actual_team1_goals < $fixture->actual_team2_goals) {
            $fixture->winning_team = $fixture->team2_id;
            $fixture->is_draw      = null;
        } else {
            $fixture->winning_team = null;
            $fixture->is_draw      = 1;
        }

        $fixture->save();

        $predictions = Prediction::where('fixture_id', $request->fixture_id)->get();

        foreach ($predictions as $prediction) {
            $winnerCorrect = (
                ($fixture->winning_team && $fixture->winning_team == $prediction->winning_team) ||
                ($fixture->is_draw && $prediction->is_draw)
            );

            $prediction->is_correct = $winnerCorrect ? 1 : 0;
            $prediction->points     = $winnerCorrect ? 5 : 0;
            $prediction->save();

            $predictionDetails = PredictionDetails::where('predication_id', $prediction->id)->get();
            foreach ($predictionDetails as $detail) {
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

        $players = DB::table('v_emp_info')
            ->where('v_emp_info.emp_status', 'Active')
            ->join('users', 'users.staff_id', '=', 'v_emp_info.emp_code')
            ->leftJoin('emps', 'emps.id', '=', 'users.emp_id')
            ->leftJoin('v_leaderboard', 'v_leaderboard.user_id', '=', 'users.id')
            ->leftJoin('my_teams', 'my_teams.user_id', '=', 'users.id')
            ->leftJoin('teams', 'teams.id', '=', 'my_teams.team_id')
            ->select(
                'v_emp_info.full_name',
                'v_emp_info.depart_name',
                'v_emp_info.emp_code',
                'users.id as user_id',
                'emps.image_path',
                DB::raw('COALESCE(v_leaderboard.total_points, 0) as total_points'),
                DB::raw('COALESCE(v_leaderboard.goal_accuracy, 0) as goal_accuracy'),
                DB::raw('COALESCE(v_leaderboard.ranking, 0) as ranking'),
                'teams.name as team_name',
                'teams.flag as team_flag',
            )
            ->orderBy('total_points', 'desc')
            ->orderBy('goal_accuracy', 'desc')
            ->get();

        $top3 = $players->take(3);

        return view('users.leaderboard', compact('favorite_team', 'players', 'top3'));
    }

    public function userPredictions($userId)
    {
        $predictions = Prediction::where('user_id', $userId)
            ->whereNotNull('is_correct')
            ->with([
                'fixture.team1',
                'fixture.team2',
                'winningTeam',
                'predictiondetails',
            ])
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($pred) {
                $fixture = $pred->fixture;
                $detail  = $pred->predictiondetails;
                return [
                    'date'            => $fixture?->date,
                    'team1_name'      => $fixture?->team1?->name,
                    'team2_name'      => $fixture?->team2?->name,
                    'team1_flag'      => $fixture?->team1?->flag,
                    'team2_flag'      => $fixture?->team2?->flag,
                    'actual_t1'       => $fixture?->actual_team1_goals,
                    'actual_t2'       => $fixture?->actual_team2_goals,
                    'pred_winner'     => $pred->is_draw ? 'Draw' : ($pred->winningTeam?->name ?? '—'),
                    'pred_t1'         => $detail?->team1_goals,
                    'pred_t2'         => $detail?->team2_goals,
                    'winner_correct'  => (int) $pred->is_correct,
                    'goal_t1_correct' => $detail ? (int) $detail->team1_goal_correct : null,
                    'goal_t2_correct' => $detail ? (int) $detail->team2_goal_correct : null,
                    'winner_points'   => (int) $pred->points,
                    'goal_points'     => (int) ($detail?->points ?? 0),
                    'points'          => (int) $pred->points + (int) ($detail?->points ?? 0),
                ];
            });

        return response()->json($predictions);
    }

    public function analytics()
    {
        $favorite_team = MyTeam::where('user_id', Auth::id())->first();

        // Implementation for analytics view
        return view('users.analytics', compact('favorite_team'));
    }

    public function updateAvatar(Request $request, $id)
    {
        $authId = Auth::id();
        if ($authId !== 1 && $authId !== (int) $id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate(['avatar' => 'required|image|max:2048']);

        $user = User::findOrFail($id);
        $emp  = DB::table('emps')->where('id', $user->emp_id)->first();

        $empCode  = $emp->emp_code ?? ('user_' . $id);
        $ext      = $request->file('avatar')->getClientOriginalExtension();
        $filename = $empCode . '.' . $ext;

        $savePath = env('PORTAL_IMAGE_SAVE_PATH', public_path('resources/images/userimages'));
        $request->file('avatar')->move($savePath, $filename);

        $relativePath = 'public/resources/images/userimages/' . $filename;
        DB::table('emps')->where('id', $user->emp_id)->update(['image_path' => $relativePath]);

        return response()->json(['success' => true, 'avatar' => 'https://myportal.galaxybd.com/public/' . $relativePath]);
    }

}
