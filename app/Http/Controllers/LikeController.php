<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // guardar los likes
    public function store(Request $request, Post $post){
        // dd($request->user()); // -> el request->user = muestra la infomracion del usuario autenticado, no el usuario de la pagina la que estamos visitando
        

        $post->likes()->create([
            'user_id' => $request->user()->id,
        ]);
        // es otra forma de crear el registro
        // Like::create([
        //     'user_id' => $request->user()->id,
        //     'post_id' => $post->id,
        // ]);
        
        return back();
    }

    public function destroy(Request $request, Post $post)
    {
        $request->user()->likes()->where('post_id', $post->id)->delete();
        return back();
    }

}