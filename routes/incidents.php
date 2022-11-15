<?php

use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "incidents", 'namespace' => '\App\Http\Controllers'], function(){
    Route::get("/{incident}/edit", "IncidentsController@show")->name("incidents.edit");
    Route::get("/{incident}/delete", "IncidentsController@destroy")->name("incidents.destroy");
    Route::post("/{incident}/update", "IncidentsController@update")->name("incidents.update");
    Route::post("/store", "IncidentsController@store")->name("incidents.store");
    Route::get("/", "IncidentsController@index")->name("incidents");
});
