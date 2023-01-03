<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TravellerExperience as ResourcesTravellerExperience;
use App\TravellerExperience;
use Illuminate\Http\Request;

class TravellerExperienceController extends Controller
{


    /**
     *Getting recently updated travellers' experince
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function recents()
    {
        try {
            $experiences = ResourcesTravellerExperience::collection(TravellerExperience::orderBy('updated_at', 'desc')
                                                                    ->limit(10)->get());
            return response()->json(['experience' => $experiences]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     *Getting details of a travellers' experince
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function details($id)
    {
       try {
            $t_exp = ResourcesTravellerExperience::collection(TravellerExperience::with('images')
                                                                        ->where('id','=',$id)->get());
            return response()->json(['experience'=> $t_exp]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
