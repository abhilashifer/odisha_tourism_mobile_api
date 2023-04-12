<?php

namespace App\Http\Controllers\Api\admin;

use App\Http\Controllers\Controller;
use App\Image;
use App\MajorCity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Util\Exception;

class MajorCityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try{
            if(Auth::check()){
                $recent_cities = MajorCity::orderBy('updated_at','desc')->get();
                return response()->json(['cities'=>$recent_cities]);
            }else{
                throw new \Exception('Unauthenticated request.');
            }
        } catch(\Exception $e) {
            return response()->json(['status'=>false,'error'=>$e->getMessage()],400);
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
            if(Auth::check()){
                $validated = $request->validate([
                    'name'=>'required',
                    'district_id'=>'required',
                    'desc_short'=>'required',
                    'thumbnail' => 'required'
                ]);
                $path = $request->file('thumbnail')->store('RecentStatus');
                $major_city = new MajorCity();
                $major_city->name = $validated['name'];
                $major_city->district_id = $validated['district_id'];
                $major_city->desc_short = $validated['desc_short'];
                $major_city->thumbnail = $path;
                $major_city->save();
                if($major_city){
                    if($request->hasFile('images')){
                        $img_data = $request->file('images');
                        foreach($img_data as $item){
                           $path = $item->store('images');
                            $img_obj = new Image();
                            $img_obj->img_path = $path;
                            $major_city->images()->save($img_obj);
                        }
                    }
                    return response()->json(['status'=>true,'message'=>'major city created','data'=>$major_city]);
                }else{
                    throw new \Exception('majorcity could not be created');
                }
            }else{
                throw new \Exception('Unauthenticated request');
            }
        } catch (\Exception $e) {
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            if(Auth::check()){
                $validated = $request->validate([
                    'name'=>'required',
                    'district_id'=>'required',
                    'desc_short'=>'required',
                    'thumbnail' => 'required'
                ]);
                $major_city = MajorCity::where('id','=',$id)->first();
                $old_thumbnail = $major_city->thumbnail;
                Storage::delete($old_thumbnail);
                $path = $request->file('thumbnail')->store('RecentStatus');
                $major_city->name = $validated['name'];
                $major_city->district_id = $validated['district_id'];
                $major_city->desc_short = $validated['desc_short'];
                $major_city->thumbnail = $path;
                $major_city->save();
                if($request->hasFile('images')){
                    $old_imgs = $major_city->images();
                    if(count($old_imgs) > 0){
                        $old_img_path = array_column($old_imgs,'img_path');
                        Storage::delete($old_img_path);
                        $major_city->images()->delete();
                    }
                    $img_data = $request->file('images');
                    foreach($img_data as $item){
                        $path = $item->store('images');
                        $img_obj = new Image();
                        $img_obj->img_path = $path;
                        $major_city->images()->save($img_obj);
                    }
                }
                if($major_city){
                    return response()->json(['status'=>true,'message'=>'major city updated','data'=>$major_city]);
                }else{
                    throw new \Exception('major city could not be updated');
                }
            }else{
                throw new \Exception('Unauthenticated request');
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>false,'error'=>$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            if(Auth::check()) {
                $major_city = MajorCity::where('id', '=', $id)->first();
                if ($major_city) {
                    $old_imgs = $major_city->images();
                    if(count($old_imgs) > 0){
                        $old_img_path = array_column($old_imgs,'img_path');
                        Storage::delete($old_img_path);
                        $major_city->images()->delete();
                    }
                    $major_city->delete();
                } else {
                    throw new Exception('Resource not found');
                }
                return response()->json(['status' => true, 'message' => 'Resource deleted successfully']);
            }else{
                throw new Exception('Unauthenticated request');
            }
        } catch(\Exception $e) {
            return response()->json(['status'=>false,'error'=> $e->getMessage()]);
        }
    }
}
