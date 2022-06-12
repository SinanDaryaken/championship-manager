<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FixtureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'number_of_week' => $this->number_of_week,
            'home_team' => $this->homeTeam->name,
            'away_team' => $this->awayTeam->name,
            'home_team_score' => $this->home_team_goals,
            'away_team_score' => $this->away_team_goals,
        ];
    }
}
