<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowerController extends Controller
{
    // guardar
    public function store(User $user, Request $request){
        // dd($user);
        $user->followers()->attach(auth()->user()->id);

        return back();
    }

    // elminar
    public function destroy(User $user, Request $request){
        $user->followers()->detach(auth()->user()->id);
        return back();
    }
}