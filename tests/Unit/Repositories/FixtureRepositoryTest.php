<?php

namespace Tests\Unit\Repositories;

use App\Models\Fixture;
use App\Repositories\FixtureRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use phpDocumentor\Reflection\Types\Integer;
use Tests\TestCase;

class FixtureRepositoryTest extends TestCase
{
    use WithFaker;

    private Fixture|Mockery $fixture;
    private FixtureRepository|Mockery $repository;

    public function setRepository()
    {
        $this->fixture = Mockery::mock(Fixture::class);
        $this->repository = Mockery::mock(FixtureRepository::class, [$this->fixture])->makePartial();
    }

    public function test_fetch_all()
    {
        $this->setRepository();
        $collection = Mockery::mock(Collection::class);
        $this->fixture->shouldReceive('all')->andReturn($collection);
        $this->assertSame($collection, $this->repository->fetchAll());
    }

    public function test_fetch_grouped_by_week()
    {
        $this->setRepository();
        $collection = Mockery::mock(Collection::class);

        $this->fixture->shouldReceive('get')->andReturnSelf();
        $this->fixture->shouldReceive('groupBy')->with('number_of_week')->andReturn($collection);

        $this->assertSame($collection, $this->repository->fetchGroupedByWeek());
    }

    public function test_fetch_counted_fixtures_week()
    {
        $this->setRepository();
        $numberOfWeek = $this->faker->randomDigitNotNull;

        $this->fixture->shouldReceive('get')->andReturnSelf();
        $this->fixture->shouldReceive('groupBy')->with('number_of_week')->andReturnSelf();
        $this->fixture->shouldReceive('count')->andReturn($numberOfWeek);

        $this->assertSame($numberOfWeek, $this->repository->fetchCountedFixturesWeek());
    }

    public function test_fetch_by_week()
    {
        $this->setRepository();
        $numberOfWeek = $this->faker->randomDigitNotNull;
        $collection = Mockery::mock(Collection::class);

        $this->fixture->shouldReceive('where')->with('number_of_week', $numberOfWeek)->andReturnSelf();
        $this->fixture->shouldReceive('get')->andReturn($collection);
        $this->assertSame($collection, $this->repository->fetchByWeek($numberOfWeek));
    }

    public function test_fetch_un_played_weeks()
    {
        $this->setRepository();
        $collection = Mockery::mock(Collection::class);

        $this->fixture->shouldReceive('where')->with('is_played', 0)->andReturnSelf();
        $this->fixture->shouldReceive('get')->andReturn($collection);
        $this->assertSame($collection, $this->repository->fetchUnPlayedWeeks());
    }
}
