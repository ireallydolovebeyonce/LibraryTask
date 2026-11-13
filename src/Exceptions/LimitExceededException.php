<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class LimitExceededException extends Exception
{
    public function __construct(string $message = 'У пользователя уже 3 книги') {
        parent::__construct($message);
    }
}