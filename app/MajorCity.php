<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;


class MajorCity extends Model
{
    use Searchable;


    protected $fillable = ['name', 'district_id', 'desc_short', 'thumbnail'];

    /**
     * Retrieving district name
     */
    public function district()
    {
        return DB::table('t_district')->select('vchDistrictName')->where('intDistrictId ', $this->district_id)->value('vchDistrictName');
    }
    /**
     * Retrieving images
     */
    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }
}
