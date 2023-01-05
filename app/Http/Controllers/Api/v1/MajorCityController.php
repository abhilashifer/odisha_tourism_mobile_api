<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\MajorCity as ResourcesMajorCity;
use App\MajorCity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MajorCityController extends Controller
{
    /**
     * Shows major city status
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function recentStatus(Request $request)
    {
        try {
            if(isset($request['district'])){
                $dis_id = DB::table('t_district')->select('intDistrictId')
                    ->where('vchDistrictName', 'like', '%' . $request['district'] . '%')->value('intDistrictId');
            }else{
                $dis_id = DB::table('t_district')->select('intDistrictId')
                    ->where('vchDistrictName', 'like', '%KHORDHA%')->value('intDistrictId');
            }
            $data = ResourcesMajorCity::collection(MajorCity::has('images')
                ->where('district_id','=',$dis_id)
                ->orderby('updated_at', 'desc')
                ->get());
            return response()->json(['status' => $data],200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 204);
        }
    }
}
