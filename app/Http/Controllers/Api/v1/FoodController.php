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
            //$user_district = strtoupper($request['district']);
          // $food = ResourcesFood::collection(Food::orderBy('updated_at','desc')->limit(30)->get());
            $foods = Food::withCount(['likes','reviews'])->orderBy('updated_at','desc')->limit(30)->get()->toArray();
            $ratings = array_column($foods,'rating');
            array_multisort($ratings, SORT_DESC, $foods);
            //$foods = ResourcesFood::collection($foods);
            return response()->json(['foods' => $foods]);
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
