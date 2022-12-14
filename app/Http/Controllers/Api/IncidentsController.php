<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Incident;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IncidentsController extends Controller
{
    public function getIncidents(Request $request){
        $incidents = Incident::orderBy("title")->get();

        $response = [
            "success" => true,
            "incidents" => $incidents,
        ];

        $user = User::where("email", $request->user)->first();
        $user->refreshToken();
        $user->fresh();

        $response["token"] = $user->api_token;
        $response["user"] = $user->email;

        return response($response, 200);
    }
}
