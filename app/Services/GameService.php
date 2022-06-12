<?php

namespace App\Services;

use App\Models\Fixture;
use App\Repositories\FixtureRepository;
use App\Repositories\TeamRepository;
use Illuminate\Database\Eloquent\Collection;

class GameService
{
    /**
     * @param TeamRepository $teamRepository
     * @param FixtureRepository $fixtureRepository
     */
    public function __construct(
        protected TeamRepository    $teamRepository,
        protected FixtureRepository $fixtureRepository
    )
    {
    }

    /**
     * @param Collection|Fixture $fixture
     * @return void
     */
    public function simulateAndStore(Collection|Fixture $fixture)
    {
        foreach ($fixture as $match) {
            $result = $this->simulationResult($match);
            $matchResult = $this->fixtureRepository->update($match, $result);
            $this->teamRepository->updateByGame($matchResult);
        }

    }

    /**
     * @param object $match
     * @return array
     */
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

    /**
     * @return array
     */
    public function predict(): array
    {
        $teams = $this->teamRepository->fetchAll();
        $pointsByTeam = [];
        foreach ($teams as $team) {
            $pointsByTeam[] = $team->points;
        }
        $maxPoint = max($pointsByTeam);
        $pointLimit = $teams->where('points', '>=', 9)->sum('points');

        $result = [];
        foreach ($teams as $team) {
            if ($maxPoint > $team->points + 9) {
                $result[] = [
                    'name' => $team->name,
                    'points' => $team->points,
                    'percentage' => 'X',
                ];
            } else {
                $result[] = [
                    'name' => $team->name,
                    'points' => $team->points,
                    'percentage' => round($team->points / $pointLimit * 100, 2),
                ];
            }
        }

        return $result;
    }

    /**
     * @param object $match
     * @return int
     */
    private function calculateInstantPowerHome(object $match): int
    {
        return rand($match->homeTeam->current_power, $match->homeTeam->potential_power) + $match->homeTeam->home_factor + rand(0, 1);
    }

    /**
     * @param object $match
     * @return int
     */
    private function calculateInstantPowerAway(object $match): int
    {
        return rand($match->awayTeam->current_power, $match->awayTeam->potential_power) + $match->awayTeam->away_factor + rand(0, 1);
    }

    /**
     * @param int $attacker
     * @param int $defender
     * @return int
     */
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
