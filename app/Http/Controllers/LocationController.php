<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\WolfController;
use App\Models\Location;
use App\Models\Wolf;
use Illuminate\Http\Request;
use Validator;

class LocationController extends Controller
{
    /**
     * Respond with location of a wolf
     *
     * @return \Illuminate\Http\Response
     */
    public function index($wolfId)
    {
        $w = Location::select('longitude', 'latitude')->where('wolf_id', $wolfId)->get();
        return response(json_encode($w), 200)
                ->header('Content-Type', 'application/json');
   }

    /**
     * Store or update location of a wolf.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $wolfId)
    {
        $validator = Validator::make($request->all(),  [
            'longitude' => 'required',
            'latitude' => 'required',
        ]);
        if ($validator->fails()) {
            return response('{"message": "Failed because not all required given."}', 404)
                ->header('Content-Type', 'application/json');
        }

        try {
            // Check if $wolfId is known.
            Wolf::FindOrFail($wolfId);

            $location = Location::Find($wolfId);
            if ($location === null) {
                $location = new Location();
                $location->wolf_id = $wolfId;
            }
            $location->longitude = $request->longitude;
            $location->latitude = $request->latitude;
            $location->save();
        }
        catch (\Exception $e) {
            return response('{"type": 1, "message": ' . json_encode($e->getMessage()) . '}', 404)
                ->header('Content-Type', 'application/json');
        }

        return response('{"type": 0, "message": "OK"}', 200)
            ->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    //public function show(Location $location)
    public function show($wolfId, $locationId)
    {
        return response('{"message": "GET api/wolves/{id}/location/{id} not implemented."}', 404)
            ->header('Content-Type', 'application/json');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        return response('{"message": "update not implemented."}', 404)
            ->header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        return response('{"message": "delete not implemented."}', 404)
            ->header('Content-Type', 'application/json');
    }
}
