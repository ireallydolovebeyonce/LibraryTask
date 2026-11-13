<?php

declare(strict_types=1);

namespace App\Enums;

enum Status: string
{
    case Available = 'available';
    case Borrowed = 'borrowed';
    case InRepair = 'repair';
}