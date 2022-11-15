<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Place;

class PlacesController extends Controller
{
    public function getPlaces(){
        $places = Place::orderBy("title")->get();
        return response(["places" => $places], 200);
    }
}
