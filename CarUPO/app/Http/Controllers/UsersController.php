<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function mostrarUsuarios()
    {
        $usuarios = User::paginate(8);
        return view('usuarios', @compact('usuarios'));
    }

    public function actualizarPerfil(Request $request)
    {
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
