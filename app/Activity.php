<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['master_subcategory_id', 'name', 'des_short', 'des_long', 'thumbnail', 'loc_cord'];

     /**
     * Get subcategory for the activity.
     */
    public function category()
    {
        return $this->belongsTo('App\MasterSubcategory');
    }

     /**
     * Get all of the reviews for the activity.
     */
    public function reviews()
    {
        return $this->morphMany('App\Review', 'reviewable');
    }
    /**
     * Get all active reviews for the activity.
     */
    public function activeReviews()
    {
        return $this->morphMany('App\Review', 'reviewable')->where('status','=',1);
    }

     /**
     * Get all of the likes for the activity.
     */
    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }

     /**
     * Get all of the images for the activity.
     */
    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

     /**
     * Get all of the tags for the Accomodation.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
