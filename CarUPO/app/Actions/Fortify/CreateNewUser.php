<?php

namespace App\Actions\Fortify;

use App\Models\Carrito_compra;
use App\Models\Favoritos;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {

        $mensajes = [
            'name.required' => 'La descripción es obligatoria',
            'surname.required' => 'La foto es obligatoria.',
            'phone.required' => 'El archivo debe ser una imagen.',
            'phone.regex' => 'El teléfono tiene que ser de entre 9 y 14 números.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'El correo es tiene que ser formato x@x.x.',
            'language.required' => 'El idioma es obligatorio.',
            'language.in' => 'El idioma tiene que ser en (Inglés) o es (Español).',
        ];

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string'],
            'phone' => ['required', 'string', 'regex:/^\+?[1-9]\d{1,14}$/'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'language' => ['required', 'string','in:es,en'],
        ], $mensajes)->validate();

        // Create user
        $user = User::create([
            'name' => $input['name'],
            'surname' => $input['surname'],
            'phone' => $input['phone'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'language' => $input['language'],
        ]);

        // Create cart and assign it to the user
        $cart = new Carrito_compra();
        $cart->user()->associate($user);
        $cart->save();

        // Create favoritos and assign it to the user
        $favoritos = new Favoritos();
        $favoritos->user()->associate($user);
        $favoritos->save();

        return $user;
    }
}
