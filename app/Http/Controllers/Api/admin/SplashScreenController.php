<?php

namespace App\Http\Controllers\Api\admin;

use App\Http\Controllers\Controller;
use App\SplashScreen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SplashScreenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $screens = SplashScreen::all();
        return response()->json(['screens'=> $screens]);
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
        try{
            if(Auth::check()){
                $validated = $request->validate([
                    'title'=>'required',
                    'thumbnail'=>'required|mimes:png,jpg,jpeg,gif',
                    'active' => 'required'
                ]);
                $path = $request->file('thumbnail')->store('splashScreen');
                $screen = new SplashScreen();
                $screen->title = $validated['title'];
                $screen->thumbnail = $path;
                $screen->active = $validated['active'];
                $screen->save();
                if($screen){
                    return response()->json(['status'=>true,'message'=> 'Resource created','data'=>$screen]);
                }else{
                    return response()->json(['status'=>false,'message'=> 'Could not be created']);
                }
            }else{
                throw new \Exception('Unauthenticated request');
            }
        } catch (\Exception $e){
            return response()->json(['error'=>$e->getMessage()],400);
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
        try{
            if(Auth::check()){
                $validated = $request->validate([
                    'title'=>'required',
                    'thumbnail'=>'required|mimes:png,jpg,jpeg,gif',
                    'active' => 'required'
                ]);
                $screen = SplashScreen::where('id','=',$id)->first();
                $old_file_path = $screen->thumbnail;
                Storage::delete($old_file_path);
                $path = $request->file('thumbnail')->store('splashScreen');
                $screen->title = $validated['title'];
                $screen->thumbnail = $path;
                $screen->active = $validated['active'];
                $screen->save();
                if($screen){
                    return response()->json(['message'=>'screen Updated','status'=>true,'data'=>$screen]);
                }else{
                    return response()->json(['message'=>'screen could not be updated','status'=>false]);
                }
            }else{
                throw new \Exception('Unauthenticated request');
            }
        } catch (\Exception $e){
            return response()->json(['error'=>$e->getMessage()],400);
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
            $screen = SplashScreen::where('id','=',$id)->first();
            $screen->delete();
            return response()->json(['message'=>'Resource deleted successfully.','status'=>true]);
        } catch (\Exception $e) {
            return response()->json(['error'=>$e->getMessage()]);
        }
    }
}
