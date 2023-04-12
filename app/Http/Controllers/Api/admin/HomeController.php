<?php

namespace App\Http\Controllers\Api\admin;

use App\Http\Controllers\Controller;
use App\MasterCategory;
use App\MasterSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
class HomeController extends Controller
{


    /**
     * Login.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['status'=>false,'error' => $validator->messages()], 200);
        }
        //Request is validated
        //Crean token
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Could not create token.',
            ], 500);
        }
        //Token created, return with success response and jwt token
        return response()->json([
            'status' => true,
            'token' => $token,
        ]);
    }
    /**
     * Get Admin user obj
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAdmin()
    {
        return response()->json(['data'=>\auth()->user()]);
    }
    /**
     * Get All the districts of odisha
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllDistricts()
    {
        try {
            $districts = DB::table('t_district')->select('intDistrictId','vchDistrictName')->get();
            return response()->json(['districts'=>$districts]);

        } catch (\Exception $e) {
            return response()->json(['status'=>false,'error'=>$e->getMessage()]);
        }
    }
    /**
     * Get All Accomodation category
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAccomodationCategory()
    {
        try {
            $categories = DB::table('t_accommodation_category')
                ->select('intCategoryId','vchCategoryName')->get();
            return response()->json(['categories'=>$categories]);

        } catch (\Exception $e) {
            return response()->json(['status'=>false,'error'=>$e->getMessage()]);
        }
    }
    /**
     * Get All Master category / what to do section
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllMasterCategory()
    {
        try {
            $categories = MasterCategory::select('id','name')->get();
            return response()->json(['categories'=>$categories]);

        } catch (\Exception $e) {
            return response()->json(['status'=>false,'error'=>$e->getMessage()]);
        }
    }
    /**
     * Get All subcategory for a mastercategory / what to do section
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSubcategoryByMasterCatId($catId)
    {
        try {
             $cats = MasterSubcategory::select('id','name')->where('master_category_id',$catId)->get();
            return response()->json(['categories'=>$cats]);

        } catch (\Exception $e) {
            return response()->json(['status'=>false,'error'=>$e->getMessage()]);
        }
    }









}
