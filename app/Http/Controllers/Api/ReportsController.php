<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Report;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    public function register(Request $request)
    {
        $response = [
            "success" => true,
            "message" => "Report sent",
        ];

        $user = User::where("email", $request->user)->first();
        $user->refreshToken();
        $user->fresh();

        try{
            $image = $this->convertImage($request->image);
            $report = new Report();
            $report->incident_id = $request->incident_type;
            $report->place_id = $request->place;
            $report->image = $image;
            $report->urgency = $request->urgency;
            $report->description = $request->description;
            $report->user_id = $user->id;
            $report->other_place = $request->otherPlaceDescription;
            $report->save();

            $report->sendMail();
        }catch(\Exception $ex){
            $response["message"] = "An error happened, try again";
            $response["success"] = false;
        }

        $response["token"] = $user->api_token;
        $response["user"] = $user->email;

        return response($response, 200);
    }

    public function convertImage($data)
    {
        $base64_string = $data;
        $file_name = "/uploads/" . Str::random(30) . ".jpg" ;
        $outputfile = storage_path() . $file_name;
        $filehandler = fopen($outputfile, 'wb');
        fwrite($filehandler, base64_decode($base64_string));
        fclose($filehandler);
        return $file_name;
    }
}
