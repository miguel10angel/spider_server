<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use Illuminate\Http\Request;

class IncidentsController extends Controller
{
    public function __construct()
    {
        $this->middleware(["auth"]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $incidents = Incident::orderBy("title")->get();
        return view("incidents.index", [
            "incidents" => $incidents
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $incident = new Incident();
        $incident->title = $request->title;
        $incident->mail = $request->mail;
        $incident->save();

        return redirect()->back()->with(["success" => "Record has been created"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function show(Incident $incident)
    {
        return view("incidents.edit", [
            "incident" => $incident
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Incident $incident)
    {
        $incident->title = $request->title;
        $incident->mail = $request->mail;
        $incident->save();

        return redirect()->back()->with(["success" => "Record has been updated"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function destroy(Incident $incident)
    {
        $incident->delete();

        return redirect()->back()->with(["success" => "Record has been deleted"]);
    }
}
