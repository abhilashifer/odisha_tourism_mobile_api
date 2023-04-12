<?php

namespace App\Http\Controllers\Api\admin;

use App\Http\Controllers\Controller;
use App\Image;
use App\TouristDestination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TouristDestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            if(Auth::check()){
                $destinations = TouristDestination::orderBy('updated_at','desc')->get();
                return response()->json(['status'=>true,'destinations'=>$destinations]);
            }else{
                throw new \Exception('Unauthenticated request');
            }
        } catch(\Exception $e) {
            return response()->json(['status'=>false,'error'=>$e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            if (Auth::check()){
                $validated = $request->validate([
                    'name'        =>'required',
                    'trip_type'   => 'required',
                    'loc_cord'    => 'required',
                    'thumbnail'   => 'required|mimes:png,jpg,jpeg,gif',
                    'address'     => 'required',
                    'district_id' => 'required',
                    'destination_category_id'=>'required',
                    'des_short'   =>'required',
                ]);
              $path = $request->file('thumbnail')->store('Destinations');
                $data = [
                    'name'        => $validated['name'],
                    'trip_type'   => $validated['trip_type'],
                    'loc_cord'    => $validated['loc_cord'],
                    'thumbnail'   => $path,
                    'address'     => $validated['address'],
                    'district_id' => $validated['district_id'],
                    'destination_category_id'=>$validated['destination_category_id'],
                    'des_short'   =>$validated['des_short']
                ];
                $des = new TouristDestination();
                $des->fill($data);
                $des->save();
                if($des){
                    if($request->hasFile('images')){
                        $imgs = $request->file('images');
                        foreach($imgs as $img){
                            $path = $img->store('images');
                            $img_obj = new Image();
                            $img_obj->img_path = $path;
                            $des->images()->save($img_obj);
                        }
                    }
                    return response()->json(['status'=>true,'message'=>'Resource created successfully.','destination'=>$des]);
                }
            }else{
                throw new \Exception('Unauthenticated request');
            }
        } catch(\Exception $e) {
            return response()->json(['status'=>false,'error'=>$e->getMessage()]);
        }
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
