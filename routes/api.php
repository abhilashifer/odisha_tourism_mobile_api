<?php

use App\Accomodation;
use App\Like;
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
    Route::post('/validate_mobile','Api\v1\HomeController@validateMobile');
    Route::post('/register','Api\v1\HomeController@register');
    Route::post('/get_user','Api\v1\HomeController@getUserObj');
    Route::post('/like','Api\v1\HomeController@createLike');
    Route::Post('/review','Api\v1\HomeController@createReview');

    Route::get('/recent_status', 'Api\v1\MajorCityController@recentStatus');

    Route::get('/experiences', 'Api\v1\TravellerExperienceController@recents');
    Route::get('/exp_detail/{id}', 'Api\v1\TravellerExperienceController@details');

    Route::get('/des_detail/{id}', 'Api\v1\TouristDestinationController@detail');
    Route::get('/recent_dest', 'Api\v1\TouristDestinationController@recentUpdates');

    Route::get('/acc_detail/{id}', 'Api\v1\AccomodationController@detail');
    Route::get('/recent_acco', 'Api\v1\AccomodationController@hotVenues');

    Route::get('/food/{id}', 'Api\v1\FoodController@detail');
    Route::get('/hot_dishes', 'Api\v1\FoodController@hotDishes');

    Route::get('/splashscreens', 'Api\v1\HomeController@getSplashScreens');
    Route::get('/home_cat','Api\v1\HomeController@homeCategories');
    Route::get('/what_to_do','Api\v1\HomeController@whatToDo');
    Route::get('/map_view','Api\v1\HomeController@getAllDataForMap');
    Route::get('/search','Api\v1\HomeController@search');


    Route::get('/sorted_events','Api\v1\EventController@getSortedEvents');
    Route::get('/event/{id}','Api\v1\EventController@detail');

    Route::get('/activity','Api\v1\ActivityController@sortedActivities');
    Route::get('/activity/{id}','Api\v1\ActivityController@detail');

    Route::get('/test', function () {

       // $user = \App\User::with('likes')->find(['id'=> 2]);
        //return response()->json(['data'=>$user->likes]);
    });
});
Route::prefix('admin')->group(function () {
 Route::post('login','Api\admin\HomeController@login');
    //Authenticated routes
   Route::middleware('auth:sanctum')->group(function(){
        Route::post('admin_user','Api\admin\HomeController@getAdmin');
        Route::get('/get_districts','Api\admin\HomeController@getAllDistricts');
        Route::get('/get_acc_cats','Api\admin\HomeController@getAccomodationCategory');
        Route::get('/get_master_cats','Api\admin\HomeController@getAllMasterCategory');
        Route::get('/get_sub_cats/{id}','Api\admin\HomeController@getSubcategoryByMasterCatId');

        Route::get('/splash_screen','Api\admin\SplashScreenController@index');
        Route::post('/splash_screen','Api\admin\SplashScreenController@store');
        Route::post('/splash_screen/{splash_screen}','Api\admin\SplashScreenController@update');
        Route::delete('/splash_screen/{splash_screen}/delete','Api\admin\SplashScreenController@destroy');

        Route::get('/major_cities','Api\admin\MajorCityController@index');
        Route::post('/major_cities','Api\admin\MajorCityController@store');
        Route::post('/major_cities/{major_cities}','Api\admin\MajorCityController@update');
        Route::delete('/major_cities/{major_cities}/delete','Api\admin\MajorCityController@destroy');

        Route::get('/tourist_destination','Api\admin\TouristDestinationController@index');
        Route::post('/tourist_destination','Api\admin\TouristDestinationController@store');
        Route::post('/tourist_destination/{tourist_destination}','Api\admin\TouristDestinationController@update');
        Route::get('/tourist_destination/{tourist_destination}/delete','Api\admin\TouristDestinationController@destroy');





   });
});





