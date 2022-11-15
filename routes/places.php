<?php

use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "places", 'namespace' => '\App\Http\Controllers'], function(){
    Route::get("/{place}/edit", "PlacesController@show")->name("places.edit");
    Route::get("/{place}/delete", "PlacesController@destroy")->name("places.destroy");
    Route::post("/{place}/update", "PlacesController@update")->name("places.update");
    Route::post("/store", "PlacesController@store")->name("places.store");
    Route::get("/", "PlacesController@index")->name("places");
});
