<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;

class TouristDestination extends Model
{
    use Searchable;

    protected $fillable = ['name', 'trip_type', 'loc_cord', 'thumbnail', 'address', 'district_id', 'destination_category_id', 'email', 'mobile_number', 'website', 'des_short', 'des_long'];

    protected $appends = ['category','district','rating'];
    /**
     * Retrieving tours
     */
    public function tours()
    {
        return $this->belongsToMany('App\Tour', 'tourist_destinations_tours');
    }
    /**
     * Retrieving category name
     */
    public function getCategoryAttribute()
    {
        return DB::table('m_attractions_category')
            ->select('vchName')->where('intCatId', $this->destination_category_id)
            ->value('vchName');
    }
    /**
     * Retrieving district name
     */
    public function getDistrictAttribute()
    {
        return DB::table('t_district')->select('vchDistrictName')->where('intDistrictId', $this->district_id)->value('vchDistrictName');
    }
    /**
     * Retrieving all images
     */
    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }
    /**
     * Retrieving all reviews
     */
    public function reviews()
    {
        return $this->morphMany('App\Review', 'reviewable');
    }
    /**
     * Retrieving all active reviews
     */
    public function activeReviews()
    {
        return $this->morphMany('App\Review', 'reviewable')->where('status','=',1);
    }
    /**
     * Retrieving all likes
     */
    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }

    /**
     * Get all of the tags for the destination.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable')->select('id','tag');
    }
    /**
     * Retrieving rating
     */
    public function getRatingAttribute()
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
