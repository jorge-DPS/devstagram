<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\Controllers\HasMiddleware;


class PerfilController extends Controller implements HasMiddleware
{
    // Perfil 

    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    public function index(User $userPerfil)
    {

        // Aplica la policy para autorizar la edición
        // En tu controlador o donde sea necesario
        if (Gate::allows('update', $userPerfil)) {
            // El usuario tiene permiso para actualizar el perfil
            dd('si tiene');
        } else {
            // 
            dd('El usuario no tiene permiso para actualizar el perfil');
        }

        dd(Gate::allows('update', $userPerfil));
        // Retorna la vista del formulario de edición
        return view('perfil.edit', compact('userPerfil'));
    }
}