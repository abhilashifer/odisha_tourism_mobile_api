<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accomodation extends Model
{
    protected $fillable = ['name', 'accomodation_cat_id', 'district_id', 'thumbnail', 'address', 'des_short', 'des_long', 'loc_cord', 'mobile_number', 'email', 'website'];

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
