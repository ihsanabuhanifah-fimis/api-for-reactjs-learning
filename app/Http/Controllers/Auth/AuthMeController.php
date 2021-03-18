<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Auth\UserResource;
use Laravel\Sanctum\HasApiTokens;

class AuthMeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $token= $request->user()->createToken('api-token')->plainTextToken;
       
     
   
        return (new UserResource($request->user()))->additional(["token" => $token]);
       
    }
}
