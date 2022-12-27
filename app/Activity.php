<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['master_subcategory_id', 'name', 'des_short', 'des_long', 'thumbnail', 'loc_cord'];

    public function subcategory()
    {
        return $this->belongsTo('App\MasterSubcategory');
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
