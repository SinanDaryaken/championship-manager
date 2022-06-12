<?php

namespace App\Http\Controllers;

use App\Http\Resources\FixtureResource;
use App\Models\Fixture;
use App\Repositories\FixtureRepository;
use App\Repositories\TeamRepository;
use App\Services\FixtureService;
use Illuminate\Http\Request;

class FixtureController extends Controller
{
    /**
     * @param TeamRepository $teamRepository
     * @param FixtureRepository $fixtureRepository
     * @param FixtureService $fixtureService
     */
    public function __construct(
        protected TeamRepository    $teamRepository,
        protected FixtureRepository $fixtureRepository,
        protected FixtureService    $fixtureService
    )
    {
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchAll()
    {
        $fixture = $this->fixtureRepository->fetchAll();
        return response()->json($fixture);
    }

    public function fetchGroupByWeek()
    {
        $fixtures = $this->fixtureRepository->fetchGroupedByWeek();

        $data = [];
        foreach ($fixtures as $week => $fixture) {
            $data[$week] = FixtureResource::collection($fixture);
        }
        return response()->json($data);
    }

    /**
     * @param int $numberOfWeek
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchByWeek(int $numberOfWeek)
    {
        $fixture = $this->fixtureRepository->fetchByWeek($numberOfWeek);
        return response()->json($fixture);
    }

    public function fetchCountedFixturesWeek()
    {
        $totalFixtureWeek = $this->fixtureRepository->fetchCountedFixturesWeek();
        return response()->json($totalFixtureWeek);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @param Fixture $fixture
     * @param Request $fixtureRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Fixture $fixture, Request $fixtureRequest)
    {
        $data = $fixtureRequest->only('home_team_goals', 'away_team_goals');
        $fixture = $this->fixtureRepository->update($fixture, $data);
        return response()->json(['data' => $fixture, 'message' => 'Match fixed']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
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
