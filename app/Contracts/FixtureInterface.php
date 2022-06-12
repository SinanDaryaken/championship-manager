<?php

namespace App\Contracts;

use App\Models\Fixture;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface FixtureInterface extends BaseInterface
{
    /**
     * @param int $numberOfWeek
     * @return Fixture
     */
    public function fetchByWeek(int $numberOfWeek): Fixture;

    /**
     * @return Collection
     */
    public function fetchGroupedByWeek(): Collection ;

    /**
     * @return Collection
     */
    public function fetchUnPlayedWeeks(): Collection;

    /**
     * @param array $fixture
     * @return void
     */
    public function store(array $fixture): void;

    /**
     * @param Fixture $fixture
     * @param array $data
     * @return Fixture
     */
    public function update(Fixture $fixture, array $data): Fixture;

    /**
     * @return Builder
     */
    public function destroyAll(): Builder;
}
