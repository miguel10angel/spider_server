<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Report extends Model
{
    use HasFactory;
    protected $fillable = [
        'incident',
        'image',
        'urgency',
        'description'
    ];

    public static function sendMail($file){
        Mail::send("mailing.report", [], function($mailing) use($file){
            $mailing->subject("Report");
            $mailing->from("miguel.a.hernandez0@gmail.com", "Whirlpool");
            $mailing->to("miguel_hernandez_teknna@whirlpool.com");
            $mailing->attach($file);
        });

    }
}