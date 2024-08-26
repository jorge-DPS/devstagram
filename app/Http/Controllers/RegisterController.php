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

    public function store(Request $request, User $user)
    {
        // dd($request); // -> aqui viene todos los datos que envia el front
        // dd($request->get('name')); //-> accede a cada valor por inidvidual
        
        // Modificar el Request
        $request->request->add(['username' => Str::slug($request->username)]);
        // Validación
        $usuario = $request->validate([
            'name' => 'required|regex:/^[a-zA-Z\s]+$/|max:30' ,
            'username' => 'required|unique:users|min:3|max:20',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6' // confirmed; calida que los password sean iguales

        ]);

        // dd($usuario);

        User::create([
            'name' => $usuario['name'],
            'username' => $request->username, //-> antes de mandar el username, al principio tenemos que hacer todo en minusculas
            'email' => $usuario['email'],
            'password' => Hash::make($usuario['password']), 
        ]);


        // Autenticar un usuario
        /* auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]); */
        
        // otra forma de autenticar
        auth()->attempt($request->only('email', 'password'));

        // Redireccionar
        return redirect()->route('posts.index', auth()->user()->username);
    }
}