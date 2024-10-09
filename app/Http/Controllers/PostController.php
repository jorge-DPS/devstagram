<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\File;

class PostController extends Controller implements HasMiddleware
{
    //


    public static function middleware(): array
    {
        return [
            new Middleware('auth', except:['show', 'index']) //-> si no esta autenticado, automaticamente llama a 'login', que es el nombre del controlador; por convencion
        ];
    }

    public function index(User $user)
    {
        // dd(auth()->user()->username);
        // dd($user->username); //-> route model binding; donde el userm¿name se muestra en el barra de navegacion

        $posts = Post::where('user_id', $user->id)->latest()->paginate(20);

        return view('dashboard', [
            // perfil del usuario
            'user' => $user,
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);

        // Crear Registro en la base de datos
        // Post::create([
        //     'titulo' => $request->titulo,
        //     'descripcion' => $request->descripcion,
        //     'imagen' => $request->imagen,
        //     'user_id' => auth()->user()->id
        // ]);

        // otra forma de crear un registro

        // $post = new Post;
        // $post->titulo = $request->titulo;
        // $post->descripcion = $request->descripcion;
        // $post->imagen = $request->imagen;
        // $post->user_id = auth()->user()->id;
        // $post->save();

        // otra forma de crear el regsitro post; esto se hace cuando le indicamos que tablas estan relacionadas; en los modelos
        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id
        ]);
        return redirect()->route('posts.index', auth()->user()->username);
    }

    public function show(User $user, Post $post)
    {
        return view('posts.show',[
            'user' => $user,
            'post' => $post,
        ]);
    }

    public function destroy(Post $post)
    {
        Gate::allows('delete', $post); // -> verifica si el usuario es el mismo que creo el post 
        $post->delete(); // elimana la publicacion

        // Eliminar la imagen
        
        $imagenPath = public_path('uploads/' . $post->imagen);
        if (File::exists($imagenPath)) {
            unlink($imagenPath);
        }

        // retorna a las publicaciones, al index
        return redirect()->route('posts.index', auth()->user()->username);
    }
}