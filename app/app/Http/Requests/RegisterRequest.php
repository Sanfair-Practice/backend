<?php

namespace App\Http\Requests;

/**
 * @property-read string $device
 */
class RegisterRequest extends CreateUserRequest
{
    public function rules(): array
    {
        $rules = [
            'device' => ['required'],
        ];
        return parent::rules() + $rules;
    }
}
