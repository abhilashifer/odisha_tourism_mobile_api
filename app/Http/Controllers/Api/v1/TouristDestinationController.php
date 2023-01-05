<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TouristDestination as ResourcesTouristDestination;
use App\Http\Resources\TouristDestinationDetail as ResourcesTouristDestinationDetail;
use App\TouristDestination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TouristDestinationController extends Controller
{

    /**
     *Getting recently updated destination near user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function recentUpdates(Request $request)
    {
        try {
            $data = [
                'near_by' =>[],
                'all'     =>[]
                 ];
            if(isset($request['district'])){
                $dis_id = DB::table('t_district')->select('intDistrictId')
                                                      ->where('vchDistrictName', 'like', '%' . $request['district'] . '%')
                                                      ->value('intDistrictId');
            }else{
                $dis_id = DB::table('t_district')->select('intDistrictId')
                                                      ->where('vchDistrictName', 'like', '%KHORDHA%')
                                                      ->value('intDistrictId');
            }
            $destinations = TouristDestination::with('activeReviews','tags','images')->orderBy('updated_at', 'desc')
                                              ->limit(30)
                                              ->get();
            foreach($destinations as $val)
            {
                if($val->district_id == $dis_id){
                    array_push($data['near_by'],$val);
                }else{
                    array_push($data['all'],$val);
                }
            }
            $ratings = array_column($data['near_by'],'rating');
            array_multisort($ratings, SORT_DESC, $data['near_by']);
            $ratings = array_column($data['all'],'rating');
            array_multisort($ratings, SORT_DESC, $data['all']);
            return response()->json(['data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     *Getting details of a destination near user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($id)
    {
        try{
            $des_detail = ResourcesTouristDestinationDetail::collection(TouristDestination::where('id','=',$id)->get());
            return response()->json(['des_detail'=>$des_detail]);
        } catch (\Exception $e){
          return response()->json(['error'=>$e->getMessage()]);
        }

    }





}
