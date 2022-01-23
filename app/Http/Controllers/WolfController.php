<?php

namespace App\Http\Controllers;

use App\Models\Pack;
use App\Models\Wolf;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use Validator;

class WolfController extends Controller
{
    /**
     * Return a listing of the wolves.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $w = Wolf::select('name','id','birth','gender')->orderBy('name')->get();
        return response(json_encode($w), 200)
                ->header('Content-Type', 'application/json');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),  [
            'name' => 'required|unique:wolf|max:30',
            'birth' => 'required',
        ]);
        if ($validator->fails()) {
            return response('{"message": "Failed"}', 404)
                ->header('Content-Type', 'application/json');      
        }
     
        try {
            $wolf = new Wolf;
            $wolf->name = $request->name;
            $wolf->gender = $request->gender;
            $wolf->birth = $request->birth;
            $wolf->save();
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
     * @param  \App\Models\Wolf  $wolf
     * @return \Illuminate\Http\Response
     */
    public function show(Wolf $wolf)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wolf  $wolf
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wolf $wolf)
    {            
        // TODO: validate request
       
        try {
            if (isset($request->name)) {
                $wolf->name = $request->name;
            }
            if (isset($request->gender)) {
                $wolf->gender = $request->gender;
            }
            if (isset($request->birth)) {
                $wolf->birth = $request->birth;
            }
            if ($wolf->isDirty()) {
                $wolf->save();
            }
        }
        catch (\Exception $e) {
            return response('{"type": 1, "message": ' . json_encode($e->getMessage()) . '}', 404)
                ->header('Content-Type', 'application/json');
        }

        return response('{"type": 0, "message": "OK"}', 200)
            ->header('Content-Type', 'application/json');      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wolf  $wolf
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wolf $wolf)
    {
        try {
            $wolf->delete();
        }
        catch (\Exception $e) {
            return response('{"type": 1, "message": ' . json_encode($e->getMessage()) . '}', 404)
                ->header('Content-Type', 'application/json');
        }

        return response('{"type": 0, "message": "Deleted"}', 200)
            ->header('Content-Type', 'application/json');
    }
    
    /**
     * Return a listing of locations of the wolves.
     *
     * @return \Illuminate\Http\Response
     */
    public function locations()
    {
        $loc = Wolf::leftJoin('locations', 'wolf.id', '=', 'locations.wolf_id')
            ->select('wolf.name', 'locations.longitude', 'locations.latitude')
            ->get();

        return response(json_encode($loc), 200)
            ->header('Content-Type', 'application/json');
    }

    /**
     * Return a listing of locations of the wolves.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addToPack(Request $request, $packId)
    {
        $pack = Pack::all()->find($packId);
        // TODO: return 404 when $pack null.
        $wolfIds = Wolf::select('id')->where('name', $request->name)->get();
        // TODO: return 404 when length $wolfIds not 1.

        try {
            $wolf = Wolf::all()->find($wolfIds[0]);
            $wolf->pack_id = $pack->id;
            $wolf->save();
        }
        catch (\Exception $e) {
            return response('{"type": 1, "message": ' . json_encode($e->getMessage()) . '}', 404)
                ->header('Content-Type', 'application/json');
        }
 
        return response('{"type": 0, "message": "Added wolf to pack"}', 200)
            ->header('Content-Type', 'application/json');
    }
 }

