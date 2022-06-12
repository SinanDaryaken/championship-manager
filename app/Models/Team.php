<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property string $name
 * @property int $potential_power
 * @property int $current_power
 * @property int $home_factor
 * @property int $away_factor
 * @property int $won
 * @property int $draw
 * @property int $lost
 * @property int $goals_for
 * @property int $goals_against
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
class Team extends Model
{
    protected $table = 'teams';
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'potential_power',
        'current_power',
        'home_factor',
        'away_factor',
        'won',
        'draw',
        'lost',
        'goals_for',
        'goals_against',
        'points',
        'created_at',
        'updated_at',
    ];
    protected $appends = ['goal_average'];
    public $timestamps = false;

    public function goalAverage(): Attribute
    {
        return new Attribute(
            get: fn($value) => $this->goals_for - $this->goals_against
        );
    }

    public function fixtures()
    {
        return $this->hasMany(Fixture::class, ['home_team_id', $this->id], ['away_team_id', $this->id]);
    }
}
