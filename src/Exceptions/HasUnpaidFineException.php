<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class HasUnpaidFineException extends Exception
{
    public function __construct(string $message = 'У читателя есть неоплаченный штраф') {
        parent::__construct($message);
    }
}
