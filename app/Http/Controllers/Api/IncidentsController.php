<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Http\Request;

class IncidentsController extends Controller
{
    public function getIncidents(){
        $incidents = Incident::orderBy("title")->get();
        return response(["incidents" => $incidents], 200);
    }
}
