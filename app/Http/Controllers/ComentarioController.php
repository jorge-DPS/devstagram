<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    // guarda  comentario
    public function store(Request $request, User $user, Post $post)
    {
        // validar
        $request->validate([
            'comentario' => 'required|max:255' 
        ]);
        // alamacenar resultado
        Comentario::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comentario' => $request->comentario,
        ]);

        // imprimier el mensaje

        return back()->with('mensaje', 'Comentario realizado correctamente');
    }
}