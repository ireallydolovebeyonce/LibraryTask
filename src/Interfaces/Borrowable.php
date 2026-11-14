<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Models\Reader;

interface Borrowable
{
    public function borrowItem(Reader $reader): void;
    public function returnItem(Reader $reader): void;
}
