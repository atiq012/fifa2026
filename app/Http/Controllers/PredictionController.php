<?php
namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Models\MyTeam;
use App\Models\Prediction;
use App\Models\PredictionDetails;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;

class PredictionController extends Controller
{
    public function index()
    {
        $predictions = Auth::user()->predictions()->where('is_correct', '<>', null)->with('fixture', 'predictiondetails')->get();

        $predictedFixtureIds = Auth::user()->predictions()
            ->where('is_correct', null)
            ->pluck('fixture_id')
            ->toArray();

        $pendingFixtures = Fixture::with('predictions.winningTeam')
            ->whereIn('id', $predictedFixtureIds)
            ->with(['team1', 'team2'])
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->limit(3)
            ->get();
        // dd($pendingFixtures);
        $favorite_team = MyTeam::where('user_id', Auth::id())->first();

        return view('users.prediction', compact('predictions', 'pendingFixtures', 'favorite_team'));
    }

    public function store(Request $request): JsonResponse
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'fixture_id'  => 'required|exists:fixtures,id',
                'prediction'  => 'required|string',
                'team1_goals' => 'nullable|integer',
                'team2_goals' => 'nullable|integer',
            ]);

            $fixture = Fixture::find($request->input('fixture_id'));

            if (! $fixture) {
                return redirect()->back()->with('error', 'Invalid fixture ID.');
            }

            $team = Team::where('name', $request->prediction)->first();

            $pre_prediction = Prediction::where('user_id', Auth::id())
                ->where('fixture_id', $request->input('fixture_id'))
                ->first();

            if ($pre_prediction) {
                $prediction             = $pre_prediction;
                $prediction->user_id    = Auth::id();
                $prediction->fixture_id = $request->input('fixture_id');
                if ($request->prediction === 'draw') {
                    $prediction->is_draw      = true; // Mark as a draw
                    $prediction->winning_team = null; // No winning team for a draw
                } else {
                    $prediction->is_draw      = null; // Not a draw
                    $prediction->winning_team = $team ? $team->id : null;
                }
                $prediction->created_by   = Auth::id();
                $prediction->save();

                $predictionDetails                 = PredictionDetails::where('predication_id', $prediction->id)->first();
                $predictionDetails->predication_id = $prediction->id;
                $predictionDetails->team1_id       = $fixture->team1_id;
                $predictionDetails->team2_id       = $fixture->team2_id;
                $predictionDetails->team1_goals    = $request->input('team1_goals');
                $predictionDetails->team2_goals    = $request->input('team2_goals');
                $predictionDetails->created_by     = Auth::id();
                $predictionDetails->save();
            } else {
                $prediction             = new Prediction();
                $prediction->user_id    = Auth::id();
                $prediction->fixture_id = $request->input('fixture_id');
                if ($request->prediction === 'draw') {
                    $prediction->is_draw      = true; // Mark as a draw
                    $prediction->winning_team = null; // No winning team for a draw
                } else {
                    $prediction->is_draw      = null; // Not a draw
                    $prediction->winning_team = $team ? $team->id : null;
                }
                $prediction->created_by   = Auth::id();
                $prediction->save();

                $predictionDetails                 = new PredictionDetails();
                $predictionDetails->predication_id = $prediction->id;
                $predictionDetails->team1_id       = $fixture->team1_id;
                $predictionDetails->team2_id       = $fixture->team2_id;
                $predictionDetails->team1_goals    = $request->input('team1_goals');
                $predictionDetails->team2_goals    = $request->input('team2_goals');
                $predictionDetails->created_by     = Auth::id();
                $predictionDetails->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Prediction saved successfully',
                'data'    => $validated,
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function predictionDetails($id)
    {
        $favorite_team = MyTeam::where('user_id', Auth::id())->first();

        $predictions = Prediction::where('fixture_id', $id)->with('predictiondetails')->get();
        return view('users.allPredictionDetails', compact('predictions','favorite_team'));

    }
}
