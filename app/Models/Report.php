<?php

namespace App\Models;

use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;
    protected $fillable = [
        'incident',
        'image',
        'urgency',
        'description'
    ];

    public function sendMail()
    {
        $data = [
            "incident" => $this->incident->title,
            'urgency' => $this->urgency,
            'description' => $this->description,
            "image" => storage_path() . $this->image,
            'place' => $this->place->title,
        ];

        $incident = $this->incident;

        Mail::send("mailing.report", $data, function($mailing) use($data, $incident){
            $mailing->subject("Report");
            $mailing->from("miguel.a.hernandez0@gmail.com", "Whirlpool");
            $mailing->to($incident->mail);
            $mailing->attach($data["image"]);
        });
    }

    public function incident(){
        return $this->belongsTo(Incident::class);
    }

    public function place(){
        return $this->belongsTo(Place::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
