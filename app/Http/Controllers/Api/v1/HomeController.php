<?php

namespace App\Http\Controllers\Api\v1;

use App\Activity;
use App\Event;
use App\Food;
use App\Http\Controllers\Controller;
use App\Accomodation;
use App\Http\Resources\SplashScreen as ResourcesSplashScreen;
use App\Http\Resources\MasterCategory as ResourceMasterCategory;
use App\MasterCategory;
use App\SplashScreen;
use App\Tag;
use App\Tour;
use App\TouristDestination;
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
        $splash = SplashScreen::where('active', 1)->orderBy('updated_at', 'desc')->limit(1)->get();
        return response()->json(["screens" => ResourcesSplashScreen::collection($splash)]);
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
         $activities = Activity::with('tags')->orderBy('updated_at','desc')->limit(30)->get()->toarray();
         $rating = array_column($activities,'rating');
         array_multisort($rating,SORT_DESC,$activities);
         $data['activities'] = $activities;
         $tours = Tour::with('tags')->orderBy('updated_at','desc')->limit(30)->get()->toArray();
            $rating = array_column($tours,'rating');
            array_multisort($rating,SORT_DESC,$tours);
         $data['tours'] = $tours;
         $events = Event::with('tags')->orderBy('updated_at','desc')->limit(30)->get()->toArray();
            $rating = array_column($events,'rating');
            array_multisort($rating,SORT_DESC,$events);
         $data['events'] = $events;
         $foods = Food::with('tags')->orderBy('updated_at','desc')->limit(30)->get()->toArray();
            $rating = array_column($foods,'rating');
            array_multisort($rating,SORT_DESC,$foods);
         $data['foods']= $foods;
         $sight = Tag::with('tours','touristDestinations','events','activities')
                     ->where('tag','LIKE','%sight%')
                     ->orWhere('tag_meta','LIKE','%sight%')
                     ->limit(30)->get();
         $data['sight_seeing'] = $sight;
        $discover = Tag::with('tours','touristDestinations','foods','events','activities','accomodations')
                        ->where('tag','LIKE','%discover%')
                        ->orWhere('tag','LIKE','%discoverOdisha%')
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
    /**
     * Get all what to do for map
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllDataForMap()
    {
        try {
            $data = [
                'activities'=>[],
                'tours' => [],
                'events' => [],
                'foods' =>[],
                'discover'=>[],
            ];
            $activities = Activity::select('name','thumbnail','loc_cord')
                ->orderBy('updated_at','desc')
                ->limit(10)
                ->get();
            $data['activities'] = $activities;
            $tours = Tour::select('name','thumbnail','loc_cord')
                ->orderBy('updated_at','desc')
                ->limit(10)
                ->get();
            $data['tours'] = $tours;
            $events = Event::select('name','thumbnail','loc_cord')
                ->orderBy('updated_at','desc')
                ->limit(10)
                ->get();
            $data['events'] = $events;
            $foods = Accomodation::select('name','thumbnail','loc_cord')
                ->whereIn('accomodation_cat_id',[1,5,6])
                ->limit(10)
                ->get();
            $data['foods'] = $foods;
            $discover = TouristDestination::select('name','thumbnail','loc_cord')
                ->orderBy('updated_at','desc')
                ->limit(10)
                ->get();
            $data['discover'] = $discover;
            return response()->json(['map_data'=>$data]);
        } catch (\Exception $e){
            return response()->json(['error'=> $e->getMessage()]);
        }
    }












}
