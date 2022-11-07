<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;

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

    public function register(Request $request){
        $response = [
            "success" => false,
            "message" => "Ocurrio un error durante el registro intentalo de nuevo mas tarde.",
        ];
        $validator = Validator::make($request->all(),[
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            $response["message"] = $validator->errors()->first();
        }

        try {
            $user = User::create([
                'name' => "$request->fname $request->lname",
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'api_token' => Str::random(60),
            ]);

            event(new Registered($user));
            Auth::login($user);

            $response = [
                "success" => true,
                "user" => $user->name,
                "token" => $user->api_token,
            ];

        } catch (\Throwable $th) {
            \Log::info($th);
        }
        return response($response, 200);
    }
}
