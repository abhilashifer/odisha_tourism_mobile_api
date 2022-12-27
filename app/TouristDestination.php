<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TouristDestination extends Model
{
    protected $fillable = ['name', 'trip_type', 'loc_cord', 'thumbnail', 'address', 'district_id', 'destination_category_id', 'email', 'mobile_number', 'website', 'des_short', 'des_long'];

    public function tours()
    {
        return $this->belongsToMany('App\Tour', 'tourist_destinations_tours');
    }

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function reviews()
    {
        return $this->morphMany('App\Review', 'reviewable');
    }

    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }
}
