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
            if(isset($request['district'])){
                $dis_id = DB::table('t_district')->select('intDistrictId')
                    ->where('vchDistrictName', 'like', '%' . $request['district'] . '%')->value('intDistrictId');
            }else{
                $dis_id = DB::table('t_district')->select('intDistrictId')
                    ->where('vchDistrictName', 'like', '%KHORDHA%')->value('intDistrictId');
            }
            $accomodations = ResourcesAccomodation::collection(Accomodation::where('district_id', $dis_id)
                                                                           ->orderBy('updated_at', 'desc')
                                                                            ->limit(5)
                                                                           ->get());
            return response()->json(['data' => $accomodations]);
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
            $acc_detail = ResourcesAccomodationDetail::collection(Accomodation::where('id','=',$id)->get());
            return response()->json(['acc_detail'=>$acc_detail]);
        } catch (\Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }



}
