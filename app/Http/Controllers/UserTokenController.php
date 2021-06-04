<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class UserTokenController extends Controller
{
    public function __invoke(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        /**  @var User $user */
        $user = User::where('email', $request->email)->first();
        
        if ( !$user || !Hash::check($request->password, $user->password) ) {
            throw ValidationException::withMessages([
                  'email' => [ 'El email ' . $request->get('email') . ' no existe o no coincide con nuestros datos.'],
       ]);
   }
        return response()->json([
            'token' => $user->createToken($request->device_name)->plainTextToken
        ]);

    }
}
/*
use Illuminate\Support\Facades\Auth;
$this->validateLogin($request);

    if (Auth::attempt($request->only('email', 'password'))) {
      return response()->json([
        'token' => $request->user()->createToken($request->name)->plainTextToken,
        'message' => 'Success'
      ]);
    }

    return response()->json([
      'message' => 'Unauthorized'
    ], 401);
  }

    public function validatelogin(Request $request)
    {
        return $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'name' => 'required'
        ]);
    }``` */