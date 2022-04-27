<?php

namespace App\Location\Contract;

interface LocationInterface
{
    public function getLocation(string $place) : array;
}