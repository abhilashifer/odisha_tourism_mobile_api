<?php

namespace App\Http\Controllers\Api\v1;

use App\Activity;
use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Activity as ResourceActivity;

class ActivityController extends Controller
{
    /**
     *Getting details of a event.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sortedActivities(Request $request)
    {
        try {
            $category_activities = [];
            $activities = Activity::with('activeReviews','tags','images')
                       ->orderBy('updated_at','desc')->limit(30)->get()->toArray();
            $rating = array_column($activities,'rating');
            array_multisort($rating,SORT_DESC,$activities);
            foreach($activities as $val){
                if(array_key_exists($val['category'],$category_activities)){
                    array_push($category_activities[$val['category']],$val);
                }else{
                    $category_activities[$val['category']]=[$val];
                }
            }
            return response()->json(['activities'=>$category_activities]);
        } catch(\Exception $e) {
            return response()->json(['error'=> $e->getMessage()]);
        }
    }
    /**
     *Getting details of a event.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($id)
    {
        try {
            $activity = Activity::find($id)->load('images');
            return response()->json(['activity'=>$activity]);
        } catch (\Exception $e) {
            return response()->json(['error'=> $e->getMessage()]);
        }

    }












}
