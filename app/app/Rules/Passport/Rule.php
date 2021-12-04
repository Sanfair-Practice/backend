<?php

namespace App\Rules\Passport;

class Rule
{

    /**
     * Validates a phone number.
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function validate(string $attribute, mixed $value, array $parameters): bool
    {
        if (!is_string($value)) {
            return false;
        }
        [$country] = $parameters;

        return $this->getCountryValidator($country)->validate($value);
    }

    /**
     * @throws \Exception
     */
    private function getCountryValidator(mixed $country): Validator
    {
        return match ($country) {
            'BY' => new Country\Belarus(),
            default => throw new \Exception("{$country} not supported.")
        };
    }
}
