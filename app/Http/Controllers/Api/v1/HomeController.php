<?php

namespace App\Http\Controllers\Api\v1;

use App\Activity;
use App\Event;
use App\Food;
use App\Http\Controllers\Controller;
use App\Http\Resources\SplashScreen as ResourcesSplashScreen;
use App\Http\Resources\MasterCategory as ResourceMasterCategory;
use App\MasterCategory;
use App\SplashScreen;
use App\Tag;
use App\Tour;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the splashscreen resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSplashScreens()
    {
        $splashs = SplashScreen::where('active', 1)->orderBy('created_at', 'desc')->limit(1)->get();
        return response()->json(["screens" => ResourcesSplashScreen::collection($splashs)]);
    }

    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        //
    }

    /**
     * Login.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function login($id)
    {
        //
    }

    /**
     * Logout
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request, $id)
    {
        //
    }
    /**
     * Get all what to do categories
     * @return \Illuminate\Http\JsonResponse
     */
    public function homeCategories()
    {
        try{
           $cats = ResourceMasterCategory::collection(MasterCategory::where('active','=',1)->get());
           return response()->json(['categories'=>$cats]);
        } catch (\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
    }
    }

    /*
     * Getting all data for what to do section
     *  @return \Illuminate\Http\JsonResponse
     */
    public function whatToDo(Request $request)
    {
        try {
         $data = [
             'activities'=>[],
             'tours' => [],
             'events' => [],
             'foods' =>[],
             'sight_seeing'=>[],
             'discover'=>[],
             'dayout'=>[],
         ];
         $activities = Activity::orderBy('updated_at','desc')->limit(30)->get();
         $data['activities'] = $activities;
         $tours = Tour::orderBy('updated_at','desc')->limit(30)->get();
         $data['tours'] = $tours;
         $events = Event::orderBy('updated_at','desc')->limit(30)->get();
         $data['events'] = $events;
         $foods = Food::orderBy('updated_at','desc')->limit(30)->get();
         $data['foods']= $foods;
         $sight = Tag::with('tours','touristDestinations','events','activities')
                     ->where('tag','LIKE','%sight%')
                     ->orWhere('tag_meta','LIKE','%sight%')
                     ->limit(30)->get();
         $data['sight_seeing'] = $sight;
        $discover = Tag::with('tours','touristDestinations','foods','events','activities','accomodations')
                        ->where('tag','LIKE','%discover%')
                        ->orWhere('tag_meta','LIKE','%discover%')
                        ->limit(30)
                        ->get();
        $data['discover']=$discover;
        $dayout = Tag::with('tours','touristDestinations','activities','events')
                      ->where('tag','LIKE','%dayout%')
                      ->orWhere('tag_meta','LIKE','%dayout%')
                      ->limit(30)
                      ->get();
        $data['dayout']=$dayout;
         return response()->json(['toDo'=> $data]);


        } catch (\Exception $e){
          return response()->json(['error'=>$e->getMessage()]);
        }
    }











}
