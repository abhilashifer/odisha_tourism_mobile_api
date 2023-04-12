<?php

namespace App\Http\Controllers\Api\v1;

use App\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Event as ResourceEvent;
class EventController extends Controller
{
    /**
     *Getting sorted events.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSortedEvents()
    {
        try {
            $data = [
               'today'=>Event::todayEvents(),
                'tomorrow'=>Event::tomorrowEvents(),
                'next_week'=>Event::nextWeekEvents(),
                'this_month'=>Event::thisMonthEvents()
            ];
            $category_events = [];
            $events = Event::orderBy('updated_at','desc')->get()->toArray();
            $rating = array_column($events,'rating');
            array_multisort($rating, SORT_DESC,$events);
            foreach($events as $val){
                if(array_key_exists($val['category'],$category_events)){
                    array_push($category_events[$val['category']],$val);
                }else{
                    $category_events[$val['category']]=[$val];
                }
            }
            return response()->json(['events'=>$data,'category_event'=>$category_events]);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
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
             $event =\App\Http\Resources\Event::collection(Event::where('id','=',$id)->get());
             return response()->json(['event'=>$event]);
        } catch (\Exception $e){
            return response()->json(['error'=> $e->getMessage()]);
    }
    }
}
