<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string|null $first_name
 * @property-read string|null $last_name
 * @property-read string|null $phone
 * @property-read string|null $password
 */
class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['alpha'],
            'last_name' => ['alpha'],
            'phone' => ['phone:BY'],
            'password' => ['confirmed'],
        ];
    }
}
