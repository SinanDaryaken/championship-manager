<?php

namespace App\Repositories;

use App\Contracts\FixtureInterface;
use App\Models\Fixture;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class FixtureRepository implements FixtureInterface
{
    /**
     * @param Fixture $model
     */
    public function __construct(protected Fixture $model)
    {
    }

    /**
     * @return Collection
     */
    public function fetchAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * @param int $numberOfWeek
     * @return Fixture
     */
    public function fetchByWeek(int $numberOfWeek): Fixture
    {
        return $this->model->where('number_of_week', $numberOfWeek)->get();
    }

    public function fetchUnPlayedWeeks(): Collection
    {
        return $this->model->where('is_played', 0)->get();
    }

    /**
     * @param array $fixture
     * @return void
     */
    public function store(array $fixture): void
    {
        foreach ($fixture as $match) {
            foreach ($match as $game) {
                $this->model->create($game);
            }
        }
    }

    /**
     * @param Fixture $fixture
     * @param array $data
     * @return Fixture
     */
    public function update(Fixture $fixture, array $data): Fixture
    {
        $data['is_played'] = 1;
        $fixture->update($data);
        return $fixture;
    }

    /**
     * @return Builder
     */
    public function destroyAll(): Builder
    {
        return $this->model->truncate();
    }
}
