<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';
    protected $fillable = ['master_subcategory_id', 'name', 'food_type', 'thumbnail', 'des_short', 'des_long'];

    public function subcategory()
    {
        return $this->belongsTo('App\MasterSubcategory');
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
