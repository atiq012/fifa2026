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
}
