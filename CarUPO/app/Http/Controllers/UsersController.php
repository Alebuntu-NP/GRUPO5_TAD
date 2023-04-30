<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function mostrarUsuarios()
    {
        $usuarios = User::paginate(8);
        return view('usuarios', @compact('usuarios'));
    }

    public function actualizarPerfil(Request $request)
    {
        $reglas = [
            'phone' => ['required', 'string', 'regex:/[6|7][0-9]{8}/'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
            ]
        ];

        $mensajes = [
            'phone.required' => 'El archivo debe ser una imagen.',
            'phone.regex' => 'El teléfono tiene que ser un número de 9 cifras que empiece por 6 o 7.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'El correo es tiene que ser formato x@x.x.',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return redirect()->route('miPerfil')->withErrors($validaciones)->withInput();
        }

        $user = User::findOrFail($request->id);
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->language = $request->language;
        $user->save();
        return app()->make(PagesController::class)->callAction('verPerfil', []);
    }

    public function actualizaPass()
    {
        return view('cambiarPassword');
    }

    public function updatePassword(Request $request)
    {
        $password = $request->password;
        $passwordCon = $request->password_confirmation;
        if ($password == $passwordCon) {
            $user = User::findOrFail($request->id);
            $user->forceFill([
                'password' => Hash::make($password),
            ])->save();
        }
        return view('miPerfil');
    }
}
