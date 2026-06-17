<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    public function create(array $input): User
    {
        Validator::make($input, [
            'username' => ['required', 'string', 'max:30', 'unique:users', 'regex:/^[a-zA-Z0-9_]+$/'],
            'password' => ['required', 'string', Password::min(8), 'confirmed'],
        ], [
            'username.required' => 'Informe um nome de usuário.',
            'username.max' => 'O nome de usuário pode ter no máximo 30 caracteres.',
            'username.unique' => 'Este nome de usuário já está em uso. Escolha outro.',
            'username.regex' => 'O nome de usuário pode conter apenas letras, números e sublinhado (_), sem espaços.',
            'password.required' => 'Informe uma senha.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação de senha não confere com a senha informada.',
        ])->validate();

        return User::create([
            'username' => $input['username'],
            'password' => $input['password'],
        ]);
    }
}
