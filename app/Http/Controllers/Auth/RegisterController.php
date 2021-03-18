<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Fortify\Rules\Password;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $registrasi = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', new Password, 'confirmed'],
            
           ]);
           $registrasi["password"] = Hash::make($request->password);
           $user= User::create($registrasi);
           $token= $user->createToken('api-token')->plainTextToken;
           
       
           
           return response()-> json([
               'message' => 'kamu sudah registrasi',
               'token' => $token
           ]);
    }
}
