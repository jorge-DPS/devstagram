<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;

class ImagenController extends Controller
{
    // Almacenar las imagenes
    public function store(Request $request)
    {
        if (!file_exists(public_path('uploads'))) {
            mkdir(public_path('uploads'), 0755, true);
        }
        
        // dd($request->hasFile('archivo') && $request->file('archivo')->isValid());
        $imagen = $request->file('archivo');
        
        $nombreImagen = Str::uuid() . "." . $imagen->extension();

        // Crear la imagen usando el nuevo método read()
        $imagenServidorSave = Image::read($imagen);

        // Ajustar la imagen a 1000x1000 píxeles
        $imagenServidorSave->resize(1000, 1000, function ($constraint) {
            // Esta es una función de cierre (closure) que se utiliza para aplicar restricciones adicionales al proceso de redimensionamiento.
            $constraint->aspectRatio(); 
            /* Esta restricción mantiene la relación de aspecto original de la imagen.
                Esto significa que la imagen no se estirará o comprimirá desproporcionadamente.
                Si la imagen original es más ancha que alta, el ancho será 1000px y el alto se ajustará proporcionalmente (y viceversa). */
            $constraint->upsize();
            /* Esta restricción evita que la imagen se agrande si sus dimensiones originales son menores que 1000x1000.
                Si la imagen original es más pequeña que 1000x1000, mantendrá su tamaño original. */
        });

        // Definir la ruta donde se guardará la imagen
        $imagenPath = public_path('uploads/' . $nombreImagen);

        // Guardar la imagen
        $imagenServidorSave->save($imagenPath);

        // Obtener la URL pública de la imagen guardada
        $imagenUrl = asset('uploads/' . $nombreImagen);

        return response()->json([
            'imagen' => $imagen->extension(),
            'ruta' => $imagenUrl,
            'nombreImagen' => $nombreImagen
        ]);
    }
}