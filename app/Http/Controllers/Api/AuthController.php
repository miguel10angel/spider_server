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
                "user" => auth()->user()->email
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

        if(!$this->validateMail($request->email)){
            $response["message"] = "Invalid mail, enter your whirlpool mail";
            return response($response, 200);
        }

        try {
            $pwd = Str::random(8);
            $user = User::create([
                'name' => "$request->fname $request->lname",
                'email' => $request->email,
                'password' => Hash::make($pwd),
                'api_token' => hash('sha256', Str::random(60)),
            ]);

            event(new Registered($user));
            $user->sendPassword($pwd);

            $response = [
                "success" => true,
                "user" => $user->name,
                "token" => $user->api_token,
                "message" => "Your password was send to your mail, please review it",
            ];

        } catch (\Throwable $th) {
            $response["message"] = "An error happened, try again";
        }
        return response($response, 200);
    }

    public function validateMail($mail){
        $mail_parts = explode("@", $mail);
        $domain = $mail_parts[1];
        if (strtolower($domain)  == "whirlpool.com") {
            return true;
        }
        return false;
    }
}
