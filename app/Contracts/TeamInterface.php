<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface TeamInterface extends BaseInterface
{
    /**
     * @param Object $match
     * @return void
     */
    public function updateByGame(object $match): void;

    /**
     * @return void
     */
    public function reset(): void;
}
