<?php

namespace App\Http\Controllers\Api\v1;

use App\Food;
use App\Http\Controllers\Controller;
use App\Http\Resources\Food as ResourcesFood;
use App\Http\Resources\FoodDetail as ResourcesFoodDetail;
use Illuminate\Http\Request;

class FoodController extends Controller
{

    /**
     *Getting recently updated foods.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function hotDishes(Request $request)
    {
        try {
            $user_district = strtoupper($request['district']);
           $food = ResourcesFood::collection(Food::sortByRating( $user_district));
            return response()->json(['foods' => $food]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     *Getting details of a food.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($id)
    {
        try{
            $food_detail = ResourcesFoodDetail::collection(Food::where('id','=', $id)->get());
            return response()->json(['food_detail'=> $food_detail]);
        } catch(\Exception $e) {
            return response()->json(['error'=>$e->getMessage()]);
        }
    }



}
