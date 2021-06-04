<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = $request->validate([
            'email' => 'required|email',
            'name' => 'required',
            'password' => 'required',
        ]);

     
        $newUser = User::create(['name' => $request->name,'email'=>$request->email,'password'=>Hash::make($request->password)]);

        return response()->json($newUser);
    }
}
