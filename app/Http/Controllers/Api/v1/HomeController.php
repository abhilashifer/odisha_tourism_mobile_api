<?php

namespace App\Http\Controllers\Api\v1;

use App\Activity;
use App\Event;
use App\Food;
use App\Http\Controllers\Controller;
use App\Accomodation;
use App\Http\Resources\SplashScreen as ResourcesSplashScreen;
use App\Http\Resources\MasterCategory as ResourceMasterCategory;
use App\Like;
use App\MasterCategory;
use App\Review;
use App\Search\Tourism;
use App\SplashScreen;
use App\Tag;
use App\Tour;
use App\TouristDestination;
use App\User;
use http\Exception;
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
     * Validatin a user by mobile number.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateMobile(Request $request)
    {
        try {
            $data = ['otp'=>'','user'=> ''];
            $mobile = $request['mobile'];
            $gen_otp = rand(10000,99999);
            $data['otp'] = $gen_otp;
            $user = User::where('mobile','=',$mobile)->get();
            if(!is_null($user)){
                $data['user']=$user;
            }
            //TODO:: SMS gateway integration to be done

            return response()->json(['data'=>$data]);
        } catch (\Exception $e) {
           return response()->json(['error'=>$e->getMessage()]);
        }
    }

    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'email'=> 'required|email|unique:users',
                'mobile' => 'required|unique:users',
                'name' => 'required'
            ]);
            $user = User::create([
                'name'=>$validated['name'],
                'email'=>$validated['email'],
                'mobile'=>$validated['mobile'],
            ]);
            if($user){
                return response()->json(['status'=>'success','user'=>$user]);
            }else{
               throw new \Exception('User not created');
            }

        } catch(\Exception $e) {
            return response()->json(['error'=> $e->getMessage()],400);
        }

    }
    /**
     * Get the user object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
     public function getUserObj(Request $request)
     {
         try {
             if(isset($request['mobile']))
             {
                 $user = User::where('mobile','=',$request['mobile'])->first();
                 if(!is_null($user)){
                     return response()->json(['user'=>$user]);
                }else{
                     throw new \Exception('No user found');
                }
             }else{
                 throw new \Exception('No mobile number given');
             }
         } catch(\Exception $e){
             return response()->json(['error'=>$e->getMessage()],400);

         }
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
    /**
     * Get all data for search query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $result = Tourism::search($request['slug'])->get();
        return response()->json(['result'=>$result]);
    }
    /**
     * create like for a given resource
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createLike(Request $request)
    {
        try {
            $user_id = $request['user_id'];
            $likeable_type = strtolower($request['likeable_type']);
            $likeable_id = $request['likeable_id'];
            switch ($likeable_type) {
                case "tourist_destination":
                    $like = Like::where('user_id','=',$user_id)
                        ->where('likeable_type','=','App\TouristDestination')
                        ->where('likeable_id','=',$likeable_id)->first();
                    if(is_null($like)){
                        $des = TouristDestination::where('id','=',$likeable_id)->first();
                        $like = new Like();
                        $like->user_id = $user_id;
                        $des->likes()->save($like);
                    }
                    break;
                case "tour":
                    $like = Like::where('user_id','=',$user_id)
                        ->where('likeable_type','=','App\Tour')
                        ->where('likeable_id','=',$likeable_id)->first();
                    if(is_null($like)) {
                        $tour = Tour::where('id', '=', $likeable_id)->first();
                        $like = new Like();
                        $like->user_id = $user_id;
                        $tour->likes()->save($like);
                    }
                    break;
                case "events":
                    $like = Like::where('user_id','=',$user_id)
                        ->where('likeable_type','=','App\Event')
                        ->where('likeable_id','=',$likeable_id)->first();
                    if(is_null($like)) {
                        $event = Event::where('id', '=', $likeable_id)->first();
                        $like = new Like();
                        $like->user_id = $user_id;
                        $event->likes()->save($like);
                    }
                    break;
                case "activity":
                    $like = Like::where('user_id','=',$user_id)
                        ->where('likeable_type','=','App\Activity')
                        ->where('likeable_id','=',$likeable_id)->first()->get();
                    if(is_null($like)) {
                        $activity = Activity::where('id', '=', $likeable_id)->first();
                        $like = new Like();
                        $like->user_id = $user_id;
                        $activity->likes()->save($like);
                    }
                    break;
                case "food":
                    $like = Like::where('user_id','=',$user_id)
                        ->where('likeable_type','=','App\Food')
                        ->where('likeable_id','=',$likeable_id)->first();
                    if(is_null($like)) {
                        $food = Food::where('id', '=', $likeable_id)->first();
                        $like = new Like();
                        $like->user_id = $user_id;
                        $food->likes()->save($like);
                    }
                    break;
                case "accomodation":
                    $like = Like::where('user_id','=',$user_id)
                        ->where('likeable_type','=','App\Accomodation')
                        ->where('likeable_id','=',$likeable_id)->first();
                    if(is_null($like)) {
                        $acco = Accomodation::find(['id', '=', $likeable_id])->first();
                        $like = new Like();
                        $like->user_id = $user_id;
                        $acco->likes()->save($like);
                    }
            }
            return response()->json(['status'=>'success'],200);

        } catch (\Exception $e) {
            return response()->json(['error'=> $e->getMessage()]);
        }
    }
    /**
     * create review for a given resource
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createReview(Request $request)
    {
        try {
            $user_id = $request['user_id'];
            $reviewable_type = strtolower($request['reviewable_type']);
            $reviewable_id = $request['reviewable_id'];
            $review_body = $request['review_body'];
            $rating = $request['rating'];
            switch ($reviewable_type) {
                case "tourist_destination":
                    $des = TouristDestination::where('id','=',$reviewable_id)->first();
                    $review = new Review();
                    $review->user_id = $user_id;
                    $review->body = $review_body;
                    $review->rating = $rating;
                    $des->reviews()->save($review);
                    break;
                case "tour":
                    $tour = Tour::where('id','=',$reviewable_id)->first();
                    $review = new Review();
                    $review->user_id = $user_id;
                    $review->body = $review_body;
                    $review->rating = $rating;
                    $tour->reviews()->save($review);
                    break;
                case "events":
                    $event = Event::where('id','=',$reviewable_id)->first();
                    $review = new Review();
                    $review->user_id = $user_id;
                    $review->body = $review_body;
                    $review->rating = $rating;
                    $event->reviews()->save($review);
                    break;
                case "activity":
                    $activity = Activity::where('id','=',$reviewable_id)->first();
                    $review = new Review();
                    $review->user_id = $user_id;
                    $review->body = $review_body;
                    $review->rating = $rating;
                    $activity->reviews()->save($review);
                    break;
                case "food":
                    $food = Food::where('id','=',$reviewable_id)->first();
                    $review = new Review();
                    $review->user_id = $user_id;
                    $review->body = $review_body;
                    $review->rating = $rating;
                    $food->reviews()->save($review);
                    break;
                case "accomodation":
                    $acco = Accomodation::where('id','=',$reviewable_id)->first();
                    $review = new Review();
                    $review->user_id = $user_id;
                    $review->body = $review_body;
                    $review->rating = $rating;
                    $acco->reviews()->save($review);
            }
            return response()->json(['status'=>'success'],200);

        } catch (\Exception $e) {
            return response()->json(['error'=>$e->getMessage()]);
        }
    }








}
