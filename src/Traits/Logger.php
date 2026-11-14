<?php

declare(strict_types=1);

namespace App\Traits;

trait Logger
{
    public function log(string $type, string $item, string $message): void
    {
        echo $type . ' «' . $item . '» ' . $message . PHP_EOL;
    }
}
