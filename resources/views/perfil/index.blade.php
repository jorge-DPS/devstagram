@extends('layouts.app')

@section('titulo')
    {{-- Editar Perfil: {{ auth()->user()->username }} --}}
    Editar Perfil: {{ $user->username }}
@endsection

@section('contenido')
    <form class="p-5" method="POST" action="{{ route('perfil.store', ['user' => $user]) }}" enctype="multipart/form-data">
        <div class="flex flex-col  md:flex-row mb-10 gap-5">
            @csrf
            <div class="md:w-1/2 bg-white shadow-xl p-6">
                <div class="mb-5">
                    <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">
                        Nombre de usuario
                    </label>
                    <input id="username" name="username" type="text" placeholder="Tú nombre de usuario"
                        class="border p-3 w-full rounded-lg @error('username') border-red-500 @enderror"
                        value="{{ auth()->user()->username }}" />
                    @error('username')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">
                        Correo
                    </label>
                    <input id="email" name="email" type="text" placeholder="Tú nombre de usuario"
                        class="border p-3 w-full rounded-lg @error('email') border-red-500 @enderror"
                        value="{{ auth()->user()->email }}" />
                    @error('email')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>


                <div class="mb-5">
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">
                        Contraseña
                    </label>
                    <input id="password" name="password" type="password"
                        class="border p-3 w-full rounded-lg @error('password') border-red-500 @enderror"
                        placeholder="Contraseña actual" />
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium"> {{ $message }}
                        </p>
                    @enderror
                </div>


            </div>

            <div class="md:w-1/2 bg-white shadow-xl p-6">
                <p class="text-blue-500 font-bold uppercase block mb-5">opcional</p>
                <div class="mb-5">
                    <label for="imagen" class="mb-2 block uppercase text-gray-500 font-bold">
                        Imagen Perfil
                    </label>
                    <input id="imagen" name="imagen" type="file" class="border p-3 w-full rounded-lg" value=""
                        accept=".jpg, .jpeg, .png">

                </div>
                <div class="mb-5">
                    <label for="new_password" class="mb-2 block uppercase text-gray-500 font-bold">Nueva Contraseña</label>
                    <input id="new_password" name="new_password" type="password"
                        class="border p-3 w-full rounded-lg @error('new_password') border-red-500 @enderror"
                        placeholder="Nueva contraseña">
                    @error('new_password')
                        <p class="bg-red-600 text-white my-2 rounded-lg text-sm p-2 text-center"> {{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="new_password_confirmation" class="mb-2 block uppercase text-gray-500 font-bold">Repite la
                        Contraseña</label>

                    <input id="new_password_confirmation" name="new_password_confirmation" type="password"
                        placeholder="Confirmar nueva contraseña" class="border p-3 w-full rounded-lg">
                </div>
            </div>
        </div>
        <input type="submit" value="Guardar cambios"
            class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full md:w-fit p-3 text-white rounded-lg">
    </form>
@endsection
