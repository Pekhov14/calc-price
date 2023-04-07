<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class CountryCodeError extends Constraint
{
    public string $message = 'Такого кода нет или он не правильный.';

    public function validatedBy()
    {
        return \get_class($this) . 'Validator';
    }
}