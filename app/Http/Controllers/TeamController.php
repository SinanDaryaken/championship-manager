<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Repositories\TeamRepository;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function __construct(
        protected TeamRepository $teamRepository
    )
    {
    }

    public function fetchAll()
    {
        $team = $this->teamRepository->fetchAll();
        return response()->json($team);
    }
}
