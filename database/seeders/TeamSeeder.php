<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $teams = ['Manchester City', 'Chelsea', 'Tottenham', 'Leicester'];
        foreach ($teams as $team) {
            $potentialPower = rand(80, 100);
            $currentPower = rand(1, $potentialPower);
            $data[] = ['name' => $team,
                'potential_power' => $potentialPower,
                'current_power' => $currentPower,
                'home_factor' => rand(1, 10),
                'away_factor' => rand(1, 5),
            ];
        }

        Team::insert($data);
    }
}
