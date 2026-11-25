<?php

namespace App\Exception;

use RuntimeException;

class ValidateException extends RuntimeException
{
    public function __construct(private readonly array $errors)
    {
        parent::__construct('Invalidate argument', 422);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

}
