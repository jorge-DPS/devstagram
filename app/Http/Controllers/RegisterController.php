<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Muestra la vista
    public function index () 
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        //dd($request);
        //dd($request->get('name'));
        
        // Modificar el Request
        $request->request->add(['username' => Str::slug($request->username)]);
        // Validación
        $usuario = $request->validate([
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:20',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6' // confirmed; calida que los password sean iguales

        ]);

        User::create([
            'name' => $usuario['name'],
            'username' => $request->username,
            'email' => $usuario['email'],
            'password' => Hash::make($usuario['password']), 
        ]);


        // Autenticar un usuario
        /* auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]); */
        auth()->attempt($request->only('email', 'password'));

        // Redireccionar
        return redirect()->route('post.index');
    }
}