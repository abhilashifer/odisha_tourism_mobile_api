<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Accomodation extends Model
{
    protected $fillable = ['name', 'accomodation_cat_id', 'district_id', 'thumbnail', 'address', 'des_short', 'des_long', 'loc_cord', 'mobile_number', 'email', 'website'];

    /**
     * Retrieving accomodation category
     */
    public function category()
    {
        return DB::table('t_accommodation_category')->select('vchCategoryName')->where('intCategoryId', $this->accomodation_cat_id)->value('vchCategoryName');
    }
    /**
     * Retrieving district name
     */
    public function district()
    {
        return DB::table('t_district')->select('vchDistrictName')->where('intDistrictId', $this->district_id)->value('vchDistrictName');
    }

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }
    /**
     * Retrieving all reviews in a single accomodation
     */
    public function reviews()
    {
        return $this->morphMany('App\Review', 'reviewable');
    }
    /**
     * Retrieving all active reviews in a single accomodation
     */
    public function activeReviews()
    {
        return $this->morphMany('App\Review', 'reviewable')->where('status','=',1);
    }
    /**
     * Retrieving all likes in a single accomodation
     */
    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }
    /**
     * Get all of the tags for the Accomodation.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
    /**
     * Retrieving rating
     */
    public function rating()
    {
        $count = count($this->reviews);
        if ($count > 0) {
            $total_rating = 0;
            foreach ($this->reviews as $val) {
                $total_rating += $val->rating;
            }
            return $total_rating / $count;
        } else {
            return 0;
        }
    }
}
