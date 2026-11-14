<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class InvalidReturnException extends Exception
{
    public function __construct(string $message = 'Читатель не брал эту книгу') {
        parent::__construct($message);
    }
}
