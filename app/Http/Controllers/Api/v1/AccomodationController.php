<?php

namespace App\Http\Controllers\Api\v1;

use App\Accomodation;
use App\Http\Controllers\Controller;
use App\Http\Resources\AccomodationDetail as ResourcesAccomodationDetail;
use App\Http\Resources\Accomodation as ResourcesAccomodation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AccomodationController extends Controller
{
    /**
     *Getting recently updated destination near user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function hotVenues(Request $request)
    {
        try {
            $data = [
                'near_by'=>[],
                'all' => []
            ];
            if(isset($request['district'])){
                $dis_id = DB::table('t_district')->select('intDistrictId')
                    ->where('vchDistrictName', 'like', '%' . $request['district'] . '%')->value('intDistrictId');
            }else{
                $dis_id = DB::table('t_district')->select('intDistrictId')
                    ->where('vchDistrictName', 'like', '%KHORDHA%')->value('intDistrictId');
            }
            $accomodations = Accomodation::with('tags')->whereIn('accomodation_cat_id',[1,2,3,4,7,8])
                                         ->orderBy('updated_at','desc')->limit(30)->get();
            foreach($accomodations as $val)
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
     *Getting recently updated destination near user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($id)
    {
        try{
            $acc_detail = ResourcesAccomodationDetail::collection(Accomodation::with('images','tags')->where('id','=',$id)->get());
            return response()->json(['acc_detail'=>$acc_detail]);
        } catch (\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }



}
