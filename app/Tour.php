<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $fillable = ['master_subcategory_id', 'district_id', 'name', 'tour_from', 'tour_to', 'des_short', 'des_long', 'loc_cord', 'additional_info'];

    public function category()
    {
        return $this->belongsTo('App\MasterSubcategory');
    }

    public function touristDestinations()
    {
        return $this->belongsToMany('App\TouristDestination', 'tourist_destinations_tours');
    }

    public function reviews()
    {
        return $this->morphMany('App\Review', 'reviewable');
    }

    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }
    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }
}
