<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('principal');
});

Route::get('/resgister', [RegisterController::class, 'index'])->name('register');
Route::post('/resgister', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout',[LogoutController::class, 'store'])->name('logout');

// Route model binding
// -> /{user} automaticamente agarra el id del usuario ya que user es una tabla(user:el atributo que quiero que se muestre en el navegador)
Route::get('/{user:username}', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
// para mostrar un recurso uno solo
Route::get('/{user:username}/posts/{post}', [PostController::class, 'show'])->name('posts.show');
// guardar comentarios
Route::post('/{user:username}/posts/{post}', [ComentarioController::class, 'store'])->name('comentarios.store');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

// Imagenes
Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');


// Like a las fotos
Route::post('/posts/{post}/likes', [LikeController::class, 'store'])->name('posts.likes.store');
Route::delete('/posts/{post}/likes', [LikeController::class, 'destroy'])->name('posts.likes.destroy');

// rutas para editar perfil
Route::get('/{user:username}/editar-perfil', [PerfilController::class, 'index'])->name('perfil.index');
Route::post('/{user:username}/editar-perfil', [PerfilController::class, 'store'])->name('perfil.store');