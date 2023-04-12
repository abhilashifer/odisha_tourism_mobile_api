<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;

class Tour extends Model
{
    use Searchable;
    protected $fillable = ['master_subcategory_id', 'district_id', 'name','thumbnail', 'tour_from', 'tour_to', 'des_short', 'des_long', 'loc_cord', 'additional_info'];
    protected $appends = ['rating','category','district'];
    public function getCategoryAttribute()
    {
        return DB::table('master_subcategories')
            ->select('name')
            ->where('id',$this->master_subcategory_id)
            ->value('name');
    }
    /**
     * Retrieving district name
     */
    public function getDistrictAttribute()
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
