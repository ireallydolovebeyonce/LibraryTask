<?php

declare(strict_types=1);

namespace src\Interfaces;

use src\Reader;

interface Borrowable
{
    public function borrowItem(Reader $reader): void;
    public function returnItem(Reader $reader): void;
}