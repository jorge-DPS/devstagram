<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Routing\Controllers\HasMiddleware;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class PerfilController extends Controller implements HasMiddleware
{
    // Perfil 

    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    public function index(User $user)
    {

        // dd($user);
        // Aplica la política para autorizar la edición
        if (! Gate::allows('update', $user)) {
            // return redirect()->route('posts.index', auth()->user()->username);
            abort(403, 'No tiene permiso para editar este perfil.');
            // O redirige al dashboard si lo deseas
            // return redirect()->route('dashboard');
        }

        return view('perfil.index', ['user' => $user]);
        // return view('perfil.index', compact('user'));

    }


    public function store(Request $request)
    {
        // dd($request);
        // Validación inicial
        $validatedData = $this->validateRequest($request);

        // Verificar la contraseña actual
        if (!auth()->attempt(['email' => auth()->user()->email, 'password' => $request->password])) {
            return back()->withErrors(['password' => 'La contraseña actual es incorrecta.']);
        }

        $user = User::find(auth()->user()->id);

        // Actualizar username si ha cambiado
        if ($user->username !== $validatedData['username']) {
            $user->username = $validatedData['username'];
        }

        // Manejar cambio de contraseña si se proporciona
        if ($request->filled('new_password')) {
            $user->password = bcrypt($request->new_password);
        }

        // Manejar subida de imagen
        if ($request->hasFile('imagen')) {
            $imagenUrl = $this->handleImageUpload($request->file('imagen'), $user);
            // dd($this->handleImageUpload($request->file('imagen'), $user));
            $user->imagen = $imagenUrl;
        }

        $user->save();

        return redirect()->route('posts.index', $user->username)->with('mensaje', 'Perfil actualizado correctamente');
    }

    private function validateRequest(Request $request)
    {
        $this->slugUsername($request);

        return $request->validate([
            'username' => ['required', 'unique:users,username,' . auth()->user()->id, 'min:3', 'max:20', 'not_in:twitter,editar-perfil'],
            'password' => 'required',
            'new_password' => 'nullable|min:6|confirmed',
            'imagen' => 'nullable|image|max:2048', // max 2MB
        ]);
    }

    private function handleImageUpload($imagen, $user)
    {
        $nombreImagen = Str::uuid() . "." . $imagen->extension();
        $userFolderPath = public_path('imagenes_perfil/' . $user->id);

        if (!File::exists($userFolderPath)) {
            File::makeDirectory($userFolderPath, 0755, true, true);
        }

        $imagenPath = $userFolderPath . '/' . $nombreImagen;
        $manager = new ImageManager(new Driver());
        $imagenServidorSave = $manager->read($imagen);
        // $imagenServidorSave->cover(1000, 1000);
        $imagenServidorSave->save($imagenPath);

        return $nombreImagen;
    }

    public function slugUsername(Request $request)
    {
        $request->request->add(['username' => Str::slug($request->username)]);
    }
}