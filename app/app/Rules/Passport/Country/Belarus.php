<?php

namespace App\Rules\Passport\Country;

use App\Rules\Passport\Validator;

final class Belarus implements Validator
{

    private const CURRENT_PATTERN = '/
            (?P<random_number>\d{7})
            (?P<region>A)
            (?P<random_index>\d{3})
            (?P<nationality>PB)
            (?P<checksum>\d)
        /x';

    private const OLD_PATTERN = '/
            (?P<gender>\d)
            (?P<dob>\d{6})
            (?P<region>[ABCHKEM])
            (?P<index>\d{3})
            (?P<nationality>PB|BA|BI)
            (?P<checksum>\d)
        /x';


    public function validate(string $value): bool {
        if (strlen($value) !== 14) {
            return FALSE;
        }

        return match($value[0]) {
            '1','2','3','4','5','6' => $this->validateFormat( self::OLD_PATTERN, $value),
            '7' => $this->validateFormat(self::CURRENT_PATTERN, $value),
            default => false
        };
    }

    private function validateFormat(string $pattern, string $value): bool
    {
        $valid = preg_match($pattern, $value, $matches) > 0;

        return $valid & $this->validateChecksum($value, (int) $matches['checksum']);
    }

    private function validateChecksum(string $value, int $checksum): bool
    {
        $numbers = [];
        for ($i = 0; $i < 13; ++$i) {
            $char = $value[$i];
            $numbers[] = is_numeric($char) ? (int) $char : ord($char) - 55;
        }
        $sum = 0;
        foreach ($numbers as $i => $number) {
            $sum += match (($i + 1) % 3) {
                1 => $number * 7,
                2 => $number * 3,
                0 => $number * 1,
            };
        }
        return $sum % 10 === $checksum;
    }

}
