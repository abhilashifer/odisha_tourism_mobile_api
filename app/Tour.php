<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tour extends Model
{
    protected $fillable = ['master_subcategory_id', 'district_id', 'name', 'tour_from', 'tour_to', 'des_short', 'des_long', 'loc_cord', 'additional_info'];

    /**
     * Retrieving category name
     */
    public function category()
    {
        return $this->belongsTo('App\MasterSubcategory');
    }
    /**
     * Retrieving district name
     */
    public function district()
    {
        return DB::table('t_district')->select('vchDistrictName')->where('intDistrictId', $this->district_id)->value('vchDistrictName');
    }
    /**
     * Get all of the destinations for the tour.
     */
    public function touristDestinations()
    {
        return $this->belongsToMany('App\TouristDestination', 'tourist_destinations_tours');
    }
    /**
     * Get all of the reviews for the tour.
     */
    public function reviews()
    {
        return $this->morphMany('App\Review', 'reviewable');
    }
    /**
     * Get all active reviews for the tour.
     */
    public function activeReviews()
    {
        return $this->morphMany('App\Review', 'reviewable')->where('status','=',1);
    }
    /**
     * Get all of the likes for the tour.
     */
    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }

    /**
     * Get all of the images for the tour.
     */
    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    /**
     * Get all of the tags for the tour.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
