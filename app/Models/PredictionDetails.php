<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PredictionDetails extends Model
{
    protected $table = 'prediction_details';

    protected $fillable = [
        'predication_id',
        'team1_id',
        'team2_id',
        'team1_goals',
        'team2_goals',
        'team1_goal_correct',
        'team2_goal_correct',
        'is_correct',
        'points',
        'created_by',
    ];

    protected $casts = [
        'team1_goal_correct' => 'boolean',
        'team2_goal_correct' => 'boolean',
        'is_correct'         => 'boolean',
    ];
}
