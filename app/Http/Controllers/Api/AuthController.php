<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function update(Request $request)
    {
        $token = Str::random(60);

        $request->user()->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        return ['token' => $token];
    }

    public function login(Request $request){

        $response = [];
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $response = [
                "success" => true,
                "token" => Str::random(60),
                "user" => auth()->user()->name
            ];
        } else {
            $response = [
                "success" => false,
                "message" => "Usuario y/o contraseña incorrecta",
            ];
        }

        return response($response, 200);
    }

    public function logout(Request $request){
        auth()->logout();
        $response = [
            "success" => true
        ];

        return response($response, 200);
    }
}
