<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Repositories\FixtureRepository;
use App\Repositories\TeamRepository;
use App\Services\FixtureService;
use Illuminate\Http\Request;

class FixtureController extends Controller
{
    public function __construct(
        protected TeamRepository    $teamRepository,
        protected FixtureRepository $fixtureRepository,
        protected FixtureService    $fixtureService
    )
    {
    }

    public function fetchAll()
    {
        $fixture = $this->fixtureRepository->fetchAll();
        return response()->json($fixture);
    }

    public function fetchByWeek(int $numberOfWeek)
    {
        $fixture = $this->fixtureRepository->fetchByWeek($numberOfWeek);
        return response()->json($fixture);
    }

    public function prepare()
    {
        $fixture = $this->fixtureRepository->fetchAll();
        if ($fixture->count() != 0) {
            return response()->json(['message' => 'Please complete current fixture']);
        }

        $teams = $this->teamRepository->fetchAll();
        if ($teams->count() < 2) {
            return response()->json(['message' => 'At least 2 teams needed to build fixture']);
        }
        $fixture = $this->fixtureService->prepare($teams);
        $this->fixtureRepository->store($fixture);

        return response()->json(['message' => 'Fixture prepared']);
    }

    public function update(Fixture $fixture, Request $fixtureRequest)
    {
        $data = $fixtureRequest->only('home_team_goals', 'away_team_goals');
        $fixture = $this->fixtureRepository->update($fixture, $data);
        return response()->json(['data' => $fixture, 'message' => 'Match fixed']);
    }

    public function refresh()
    {

        $teams = $this->teamRepository->fetchAll();
        $pointsByTeam = [];
        foreach($teams as $team){
            $pointsByTeam[] = $team->points;
        }
        dd($pointsByTeam);
        $maxPoint = max($pointsByTeam);

        $total = $teams->where('points', '>=', 9)->sum('points');
        dd($total);

        dd('STOP');
        $teams = $this->teamRepository->fetchAll();
        if ($teams->count() < 2) {
            return response()->json(['message' => 'At least 2 teams needed to build fixture']);
        }
        $this->fixtureRepository->destroyAll();
        $this->teamRepository->reset();
        $fixture = $this->fixtureService->prepare($teams);
        $this->fixtureRepository->store($fixture);

        return response()->json(['message' => 'Fixture refreshed']);
    }
}
