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
    
        ];

        $mensajes = [
            'phone.required' => 'El teléfono es obligatorio.',
            'phone.regex' => 'El teléfono tiene que ser un número de 9 cifras que empiece por 6 o 7.',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return redirect()->route('miPerfil')->withErrors($validaciones)->withInput();
        }

        $user = User::findOrFail($request->id);
        $user->phone = $request->phone;
        $user->language = $request->language;
        $user->save();
        return redirect()->route('miPerfil')->with('success', '¡Perfil actualizado correctamente!');
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
        return redirect()->route('miPerfil')->with('success', '¡Contraseña actualizada correctamente!');
    }
}
