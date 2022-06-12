<?php

namespace App\Http\Controllers;

use App\Repositories\FixtureRepository;
use App\Services\GameService;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function __construct(
        protected FixtureRepository $fixtureRepository,
        protected GameService $gameService,
    )
    {
    }

    public function completeGame()
    {
        $fixture = $this->fixtureRepository->fetchUnPlayedWeeks();
        $this->gameService->simulateAndStore($fixture);
        return response()->json(['message' => 'Game completed']);
    }
}
