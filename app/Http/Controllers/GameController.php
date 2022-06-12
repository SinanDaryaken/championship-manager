<?php

namespace App\Http\Controllers;

use App\Repositories\FixtureRepository;
use App\Services\GameService;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * @param FixtureRepository $fixtureRepository
     * @param GameService $gameService
     */
    public function __construct(
        protected FixtureRepository $fixtureRepository,
        protected GameService       $gameService,
    )
    {
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function completeGame()
    {
        $fixture = $this->fixtureRepository->fetchUnPlayedWeeks();
        $this->gameService->simulateAndStore($fixture);
        return response()->json(['message' => 'Game completed']);
    }

    /**
     * @param int $numberOfWeek
     * @return \Illuminate\Http\JsonResponse
     */
    public function playGameByWeek(int $numberOfWeek)
    {
        $fixture = $this->fixtureRepository->fetchByWeek($numberOfWeek);
        $this->gameService->simulateAndStore($fixture);
        return response()->json(['message' => 'Week completed']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function predict()
    {
        $predict = $this->gameService->predict();
        return response()->json($predict);
    }
}
