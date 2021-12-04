<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
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
