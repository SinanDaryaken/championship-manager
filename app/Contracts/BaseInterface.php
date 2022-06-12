<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface BaseInterface
{
    /**
     * @return Collection
     */
    public function fetchAll(): Collection;
}
