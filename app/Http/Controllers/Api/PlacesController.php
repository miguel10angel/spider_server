<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Place;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlacesController extends Controller
{
    public function getPlaces(Request $request){
        $places = Place::orderBy("title")->get();
        $response = [
            "success" => true,
            "places" => $places,
        ];
        $user = User::where("email", $request->user)->first();
        $user->refreshToken();
        $user->fresh();
        $response["token"] = $user->api_token;
        $response["user"] = $user->email;
        return response($response, 200);
    }
}
