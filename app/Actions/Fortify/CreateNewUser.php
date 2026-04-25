<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        Validator::make($input, [
            'username' => ['required', 'string', 'max:30', 'unique:users', 'regex:/^[a-zA-Z0-9_]+$/'],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'username' => $input['username'],
            'password' => $input['password'],
        ]);
    }
}
