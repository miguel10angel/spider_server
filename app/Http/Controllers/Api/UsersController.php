<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function users(){
        $users = User::all();
        return response(["users" => $users], 200);
    }
}
