<?php

namespace App\Http\Controllers;

use App\Models\Pack;
use App\Models\Wolf;
use Illuminate\Http\Request;
use Validator;

class PackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packs = Pack::all();
        $p = array();
        foreach ($packs as $pack) {
            $w = array();
            $wolves = Wolf::where('pack_id', $pack->id)->get();
            foreach ($wolves as $wolf) {
                $w[] = ['name' => $wolf->name];
            }
            $p[] = ['name' =>$pack->name, 'wolves' => $w];
        }
        $res = ['packs' => $p];
        
        return response()->json($res, 200)
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
        ]);
        if ($validator->fails()) {
            return response('{"message": "Failed"}', 404)
                ->header('Content-Type', 'application/json');      
        }
     
        try {
            $pack = new Pack;
            $pack->name = $request->name;
            $pack->save();
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
     * @param  \App\Models\Pack  $pack
     * @return \Illuminate\Http\Response
     */
    public function show(Pack $pack)
    {
        //
        echo "show pack";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pack  $pack
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pack $pack)
    {
        //
        echo "update pack";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pack  $pack
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pack $pack)
    {
        //
        echo "remove pack";
    }
}
