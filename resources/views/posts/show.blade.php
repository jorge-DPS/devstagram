@extends('layouts.app')

@section('titulo')
    {{ $post->titulo }}
@endsection

@section('contenido')
    <div class="container mx-auto md:flex">
        <div class="md:w-1/2">
            <div class="flex justify-between items-center mx-5 md:mx-0">
                <div class="mb-2">
                    <p class="font-bold"> {{ $post->user->username }} </p>
                    <p class="text-sm text-gray-500"> {{ $post->created_at->diffForHumans() }} </p>

                </div>
                <div>
                    @auth
                        <livewire:like-post :post="$post" />

                    @endauth
                    {{-- <p>{{ dd($post)->likes }} Likes</p> --}}

                </div>
            </div>
            <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del post {{ $post->titulo }}">
            <p class="text-gray-500 uppercase text-sm font-bold mt-3 text-center">Descripcion</p>
            <p class="text-center">
                {{ $post->descripcion }}
            </p>

            <div class="flex justify-center">
                @auth
                    @if ($post->user_id === auth()->user()->id)
                        <form action="{{ route('posts.destroy', $post) }}" method="POST">
                            @method('DELETE') {{-- Method spuffing --}}
                            @csrf
                            <input type="submit" value="Elminar Publicación" name="" id=""
                                class="bg-red-500 hover:bg-red-600 p-2 rounded text-white font-bold mt-4 cursor-pointer">
                        </form>
                    @endif

                @endauth
            </div>

        </div>
        <div class="md:w-1/2 px-5 pb-5">
            @auth()
                <p class="text-xl font-bold text-center mb-4 mt-8 md:mt-0"> Agrega un nuevo comentario </p>
                <div class="shadow-xl bg-white p-5 mx-5 mb-8">
                    @if (session('mensaje'))
                        <div class="bg-green-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold">
                            {{ session('mensaje') }}
                        </div>
                    @endif

                    <form action=" {{ route('comentarios.store', ['user' => $user, 'post' => $post]) }}" method="POST">
                        @csrf
                        <div class="mb-5">
                            <label for="comentario" class="mb-2 block uppercase text-gray-500 font-bold">Caja de
                                Comentario</label>
                            <textarea name="comentario" id="comentario"
                                class="border p-3 w-full rounded-lg @error('comentario') border-red-500 @enderror"
                                placeholder="Escribe un comentario"></textarea>

                            @error('comentario')
                                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                            @enderror
                        </div>
                        <input type="submit" value="Comentar"
                            class="bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg">
                    </form>
                </div>
            @endauth

            <p class="text-xl font-bold text-center mb-4 uppercase"> Comentarios </p>
            <div class="overflow-y-scroll ">
                @if ($post->comentarios->count())
                    @foreach ($post->comentarios as $item)
                        <div class="m-5 p-5 bg-white shadow-xl rounded-lg">
                            {{-- {{ dd($post->comentarios) }} --}}
                            <a href="{{ route('posts.index', $item->user) }}" class="italic font-bold text-blue-500">
                                {{ $item->user->username }}
                            </a>
                            <p>{{ $item->comentario }}</p>
                            <p class="text-sm text-gray-500">{{ $item->created_at->diffForHumans() }}</p>

                        </div>
                    @endforeach
                @else
                    <p class="p-10 text-center">No hay comentarios áun</p>
                @endif

            </div>

        </div>
    </div>
@endsection
