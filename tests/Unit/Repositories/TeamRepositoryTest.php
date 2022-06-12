<?php

namespace Tests\Unit\Repositories;

use App\Models\Team;
use App\Repositories\TeamRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class TeamRepositoryTest extends TestCase
{
    use WithFaker;

    private Team|Mockery $team;
    private TeamRepository|Mockery $repository;

    public function setRepository()
    {
        $this->team = Mockery::mock(Team::class);
        $this->repository = Mockery::mock(TeamRepository::class, [$this->team])->makePartial();
    }

    public function test_fetch_all()
    {
        $this->setRepository();
        $collection = Mockery::mock(Collection::class);
        $this->team->shouldReceive('all')->andReturn($collection);
        $this->assertSame($collection, $this->repository->fetchAll());
    }

    public function test_fetch_all_and_ordered()
    {
        $this->setRepository();
        $collection = Mockery::mock(Collection::class);

        $this->team->shouldReceive('orderByDesc')->with('points')->andReturn($this->team);
        $this->team->shouldReceive('get')->andReturn($collection);

        $this->assertSame($collection, $this->repository->fetchAllAndOrdered());
    }

    public function test_reset()
    {
        $this->setRepository();

        $this->team->shouldReceive('query')->andReturnSelf();
        $this->team->shouldReceive('update')->andReturnSelf();
        $this->assertSame(null, $this->repository->reset());
    }
}
