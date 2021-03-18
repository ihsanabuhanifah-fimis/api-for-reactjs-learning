<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\Auth\UserResource;



class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email'=> 'required',
            'password' => 'required'
        ]);

        $user = User::whereEmail($request->email)->first();
        if(!$user || ! Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'message' => ["Email dan Password tidak cocok"]
            ]);
        }
        // $user->tokens()->delete();
        $token= $user->createToken('api-token')->plainTextToken;
       
     
   
        return (new UserResource($user))->additional([
            "token" => $token,
            'message' => "Login Success",
            'status' => '200'
            ]);
    }
}
