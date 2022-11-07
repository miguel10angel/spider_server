<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReportsController extends Controller
{
    public function register(Request $request)
    {
        $response = [
            "success" => true,
            "message" => "Report sent",
            "token" => Str::random(60),
            "user" => "Mike",
        ];

        try{
            $image = $this->convertImage($request->image);
            Report::create([
                'incident' => $request->incident_type,
                'image' => $image,
                'urgency' => $request->urgency,
                'description' => $request->description,
            ]);
            Report::sendMail(storage_path() . $image);
        }catch(\Exception $ex){
            \Log::info($ex);
        }

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
