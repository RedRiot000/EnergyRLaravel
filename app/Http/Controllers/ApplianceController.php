<?php

namespace App\Http\Controllers;

use App\Appliances;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ApplianceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $appliances = Appliances::all();
        return response()->json([
            'status' => 400,
            'message' => 'applainces found',
            'data' => $appliances
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
        $this->validate($request, [
            'name' => 'required',
            'normal_power' => 'required',
            'alternate_power' => 'required',
            'description' => 'required',
        ]);

        $appliance = new Appliances($request->all());

        if ($appliance->save())
            return response()->json([
                'success' => true,
                'data' => $appliance->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Appliance could not be added'
            ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $appliance = Appliances::find($id);
        if (!$appliance) {
            return response()->json([
                'success' => false,
                'message' => 'appliance with id ' . $id . ' not found'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $appliance
        ], 400);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'normal_power' => 'required',
            'alternate_power' => 'required',
            'description' => 'required',
        ]);

        $appliance = Appliances::find($id);

        if ($appliance) {
            $appliance->name = $request->get('name');
            $appliance->normal_power = $request->get('normal_power');
            $appliance->alternate_power = $request->get('alternate_power');
            return response()->json([
                'success' => true,
                'data' => $appliance->toArray()
            ]);
        }
        else
            return response()->json([
                'success' => false,
                'message' => 'Appliance could not be added'
            ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $appliance = Appliances::find($id);

        if (!$appliance) {
            return response()->json([
                'success' => false,
                'message' => 'Appliance with id ' . $id . ' not found'
            ], 400);
        }

        if ($appliance->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Appliance could not be deleted'
            ], 500);
        }
    }
}
