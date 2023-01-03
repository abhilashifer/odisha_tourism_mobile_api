<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\MajorCity as ResourcesMajorCity;
use App\MajorCity;
use Exception;
use Illuminate\Http\Request;

class MajorCityController extends Controller
{
    /**
     * Shows major city status
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function recentStatus()
    {
        try {
            $data = ResourcesMajorCity::collection(MajorCity::has('images')
                ->orderby('updated_at', 'desc')
                ->get());
            return response()->json(['status' => $data],200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 204);
        }
    }
}
