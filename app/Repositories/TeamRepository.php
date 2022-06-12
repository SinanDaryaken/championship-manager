<?php

namespace App\Repositories;

use App\Contracts\TeamInterface;
use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

class TeamRepository implements TeamInterface
{
    /**
     * @param Team $model
     */
    public function __construct(protected Team $model)
    {
    }

    /**
     * @return Collection
     */
    public function fetchAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * @return void
     */
    public function reset(): void
    {
        $this->model->query()->update(['won' => 0, 'draw' => 0, 'lost' => 0, 'goals_for' => 0, 'goals_against' => 0]);
    }

    /**
     * @param object $match
     * @param array $data
     * @return void
     */
    public function update(object $match): void
    {
        $homeTeamGoals = $match->home_team_goals;
        $awayTeamGoals = $match->away_team_goals;
        if ($homeTeamGoals > $awayTeamGoals) {// home team wins
            $homeTeam = ['won' => $match->homeTeam->won + 1, 'goals_for' => $match->homeTeam->goals_for + $homeTeamGoals, 'goals_against' => $match->homeTeam->goals_against + $awayTeamGoals];
            $awayTeam = ['lost' => $match->awayTeam->lost + 1, 'goals_for' => $match->awayTeam->goals_for + $awayTeamGoals, 'goals_against' => $match->awayTeam->goals_against + $homeTeamGoals];
        } else if ($homeTeamGoals < $awayTeamGoals) {//away team wins
            $homeTeam = ['lost' => $match->homeTeam->lost + 1, 'goals_for' => $match->homeTeam->goals_for + $homeTeamGoals, 'goals_against' => $match->homeTeam->goals_against + $awayTeamGoals];
            $awayTeam = ['won' => $match->awayTeam->won + 1, 'goals_for' => $match->awayTeam->goals_for + $awayTeamGoals, 'goals_against' => $match->awayTeam->goals_against + $homeTeamGoals];
        } else {//draw
            $homeTeam = ['draw' => $match->homeTeam->draw + 1, 'goals_for' => $match->homeTeam->goals_for + $homeTeamGoals, 'goals_against' => $match->homeTeam->goals_against + $awayTeamGoals];
            $awayTeam = ['draw' => $match->awayTeam->draw + 1, 'goals_for' => $match->awayTeam->goals_for + $awayTeamGoals, 'goals_against' => $match->awayTeam->goals_against + $homeTeamGoals];
        }
        $match->homeTeam->update($homeTeam);
        $match->awayTeam->update($awayTeam);
    }
}
