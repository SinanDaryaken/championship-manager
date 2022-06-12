<?php

namespace App\Contracts;

interface TeamInterface extends BaseInterface
{
    /**
     * @param Object $match
     * @return void
     */
    public function update(object $match): void;

    /**
     * @return void
     */
    public function reset(): void;
}
