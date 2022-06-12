<?php

namespace App\Services;

use App\Repositories\FixtureRepository;
use App\Repositories\TeamRepository;
use Illuminate\Database\Eloquent\Collection;

class GameService
{
    public function __construct(
        protected TeamRepository    $teamRepository,
        protected FixtureRepository $fixtureRepository
    )
    {
    }

    public function simulateAndStore(Collection $fixture)
    {
        foreach ($fixture as $match) {
            $result = $this->simulationResult($match);
            $matchResult = $this->fixtureRepository->update($match, $result);
            $this->teamRepository->update($matchResult);
        }

    }

    public function simulationResult(object $match): array
    {
        $home = 0;
        $away = 0;

        for ($i = 5; $i <= 90; $i += 5) {
            $instantHomePower = $this->calculateInstantPowerHome($match);
            $instantAwayPower = $this->calculateInstantPowerAway($match);
            if ($instantHomePower > $instantAwayPower) {
                $instantAwayPower = $this->calculateInstantPowerAway($match);
                $home += $this->completePosition($instantHomePower, $instantAwayPower);
            } else {
                $instantHomePower = $this->calculateInstantPowerHome($match);
                $away += $this->completePosition($instantAwayPower, $instantHomePower);

            }
        }
        return [
            'home_team_goals' => $home,
            'away_team_goals' => $away,
        ];
    }

    public function predict()
    {
        $teams = $this->teamRepository->fetchAll();
        $leader = $teams->sortByDesc('points')->points;
        $total = $teams->where('points', '>=', $leader - 9)->sum('points');
    }

    private function calculateInstantPowerHome(object $match): int
    {
        return rand($match->homeTeam->current_power, $match->homeTeam->potential_power) + $match->homeTeam->home_factor + rand(0, 1);
    }

    private function calculateInstantPowerAway(object $match): int
    {
        return rand($match->awayTeam->current_power, $match->awayTeam->potential_power) + $match->awayTeam->away_factor + rand(0, 1);
    }

    private function completePosition(int $attacker, int $defender): int
    {
        $striker = rand(1, 10);
        $goalKeeper = rand(5, 10);

        if ($attacker > $defender && $striker > $goalKeeper) {
            return 1;
        }
        return 0;
    }
}
