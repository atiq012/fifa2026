<?php

namespace App\Models;

use App\Models\PredictionDetails;
use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{

    public function fixture()
    {
        return $this->belongsTo(Fixture::class);
    }

    public function winningTeam()
    {
        return $this->belongsTo(Team::class, 'winning_team');
    }

    public function predictiondetails()
    {
        return $this->belongsTo(PredictionDetails::class,'id','predication_id');
    }

    public function total_predictions($f_id)
    {
        return Prediction::where('fixture_id', $f_id)->count();
    }

    public function total_win_predictions($f_id, $team_id)
    {
        return Prediction::where('fixture_id', $f_id)->where('winning_team', $team_id)->count();
    }
}
