<?php

namespace App\Services;

use App\Models\Fixture;
use App\Models\Team;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class FixtureService
{
    /**
     * @param EloquentCollection $teams
     * @return array
     */
    public function prepare(EloquentCollection $teams): array
    {
        $teamIds = $teams->shuffle()->pluck('id')->toArray();
        $totalTeam = $teams->count();
        $matchArray = [];
        $perMatchWeek = ($totalTeam % 2 == 1 ? $totalTeam - 1 : $totalTeam) / 2;
        $totalWeek = ($totalTeam % 2 == 0 ? $totalTeam - 1 : $totalTeam) * 2;


        if ($totalTeam % 2 == 1) {
            $totalTeam = $totalTeam + 1;
            $teamIds[] = 'pass';
        }

        for ($counter = 1; $counter <= $totalWeek; $counter++) {
            foreach ($teamIds as $key => $team) {
                if ($key >= $totalTeam / 2) {
                    break;
                }

                $homeTeam = $team;
                $awayTeam = $teamIds[($totalTeam - $key - 1)];
                if (gettype($homeTeam) != 'string' && gettype($awayTeam) != 'string') {
                    if ($counter % 2 == 1) {
                        $matchArray[$counter][] = ['number_of_week' => $counter, 'home_team_id' => $homeTeam, 'away_team_id' => $awayTeam];
                    } else {
                        $matchArray[$counter][] = ['number_of_week' => $counter, 'home_team_id' => $awayTeam, 'away_team_id' => $homeTeam];
                    }
                }
            }

            $temp[] = $teamIds[0];
            $secondTeam = $teamIds[1];
            array_shift($teamIds);
            array_shift($teamIds);
            $temp = array_merge($temp, $teamIds);
            $temp[] = $secondTeam;
            $teamIds = $temp;
        }

        return $matchArray;
    }
}
