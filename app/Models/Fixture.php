<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property int $home_team_id
 * @property int $away_team_id
 * @property int number_of_week
 * @property int $home_team_goals
 * @property int $away_team_goals
 * @property boolean $is_played
 */
class Fixture extends Model
{
    protected $table = 'fixtures';
    protected $guarded = ['id'];
    protected $fillable = [
        'id',
        'home_team_id',
        'away_team_id',
        'number_of_week',
        'home_team_goals',
        'away_team_goals',
        'is_played'
    ];
    public $timestamps = false;

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }
}
