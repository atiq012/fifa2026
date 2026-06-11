<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    public function team1()
    {
        return $this->belongsTo(Team::class, 'team1_id');
    }

    public function team2()
    {
        return $this->belongsTo(Team::class, 'team2_id');
    }

    public function predictions()
    {
        return $this->hasMany(Prediction::class);
    }

    public function getTimeForCompareAttribute()
    {
        return \Carbon\Carbon::createFromFormat('h:i A', $this->time)->format('H:i:s');
    }

    public function scopeUpcoming($query)
    {
        // dd($query);
        return $query->where(function ($q) {
            $q->where('date', '>', now()->toDateString())
                ->orWhere(function ($subQ) {
                    $subQ->where('date', '=', now()->toDateString())
                        ->whereRaw("STR_TO_DATE(time, '%h:%i %p') > ?", [now()->format('H:i:s')]);
                });
        })->whereNull('actual_team1_goals');
    }
}
