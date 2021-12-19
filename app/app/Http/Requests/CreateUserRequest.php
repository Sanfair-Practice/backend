<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $first_name
 * @property-read string $last_name
 * @property-read string $phone
 * @property-read string $passport
 * @property-read string $email
 * @property-read string $password
 */
class CreateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
           'first_name' => ['required', 'alpha'],
           'last_name' => ['required', 'alpha'],
            // TODO extract supported countries to config.
           'phone' => ['required', 'phone:BY'],
           'passport' => ['required', 'passport:BY'],
           'email' => ['required', 'email:rfc', 'unique:users'],
           'password' => ['required', 'confirmed'],
        ];
    }
}
