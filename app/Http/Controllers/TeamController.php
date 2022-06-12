<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Repositories\TeamRepository;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * @param TeamRepository $teamRepository
     */
    public function __construct(
        protected TeamRepository $teamRepository
    )
    {
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchAllAndOrdered ()
    {
        $team = $this->teamRepository->fetchAllAndOrdered();
        return response()->json($team);
    }
}
