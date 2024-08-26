<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    // cerrar sesión
    public function store(){
        // dd('cerrando sesión');
        auth()->logout();

        return redirect()->route('login');
    }
}