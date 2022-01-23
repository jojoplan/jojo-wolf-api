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
        //
        echo "store";
        echo $wolfId;
        $validator = Validator::make($request->all(),  [
            'longitude' => 'required',
            'latitude' => 'required',
        ]);
        if ($validator->fails()) {
            return response('{"message": "Failed because not all required given."}', 404)
                ->header('Content-Type', 'application/json');      
        }
     
        try {
            $loc = new Location;
            // TODO: set longitude and latitude in the constructor.
            $loc->longitude = $request->longitude;
            $loc->latitude = $request->latitude;
            
            $wolf = Wolf::find($wolfId);
            $wolf->locations()->save($loc);
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
        //
        echo "show";
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
        //
        echo "update";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        //
        echo "delete";
    }
}
