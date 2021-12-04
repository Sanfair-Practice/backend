<?php

namespace App\Rules\Passport;

interface Validator
{

    /**
     * Validates passport number.
     *
     * @param string $value
     *   Passport number.
     * @return bool
     *   Result.
     */
    public function validate(string $value): bool;

}
