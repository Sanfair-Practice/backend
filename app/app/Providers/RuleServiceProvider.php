<?php

namespace App\Providers;

use App\Rules\Passport;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Factory as Validator;

class RuleServiceProvider extends ServiceProvider
{

    public function boot(Validator $validator): void
    {
        $validator->extend('passport', Passport\Rule::class);
    }
}
