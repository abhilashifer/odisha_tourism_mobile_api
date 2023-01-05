<?php

use App\Accomodation;
use App\TouristDestination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {
    Route::get('/splashscreens', 'Api\v1\HomeController@getSplashScreens');
    Route::get('/recent_status', 'Api\v1\MajorCityController@recentStatus');
    Route::get('/recent_dest', 'Api\v1\TouristDestinationController@recentUpdates');
    Route::get('/recent_acco', 'Api\v1\AccomodationController@hotVenues');
    Route::get('/hot_dishes', 'Api\v1\FoodController@hotDishes'); //sorting by rating will be implemanted
    Route::get('/experiences', 'Api\v1\TravellerExperienceController@recents');
    Route::get('/exp_detail/{id}', 'Api\v1\TravellerExperienceController@details');
    Route::get('/des_detail/{id}', 'Api\v1\TouristDestinationController@detail');
    Route::get('/acc_detail/{id}', 'Api\v1\AccomodationController@detail');
    Route::get('/food/{id}', 'Api\v1\FoodController@detail');
    Route::get('/home_cat','Api\v1\HomeController@homeCategories');
    Route::get('/what_to_do','Api\v1\HomeController@whatToDo');
    Route::get('/map_view','Api\v1\HomeController@getAllDataForMap');
    Route::get('/sorted_events','Api\v1\EventController@getSortedEvents');
    Route::get('/event/{id}','Api\v1\EventController@detail');
    Route::get('/activity','Api\v1\ActivityController@sortedActivities');
    Route::get('/activity/{id}','Api\v1\ActivityController@detail');




    Route::get('/test', function () {

     return response()->json(['data'=>\App\Http\Resources\Accomodation::collection(Accomodation::all())]);

    });
});
