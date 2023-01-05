<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Activity extends Model
{
    protected $fillable = ['master_subcategory_id', 'name', 'des_short', 'des_long', 'thumbnail', 'loc_cord'];

    protected $appends = ['category','rating'];
    protected $primaryKey = 'id';
    public function getCategoryAttribute()
    {
        return DB::table('master_subcategories')
            ->select('name')
            ->where('id',$this->master_subcategory_id)
            ->value('name');
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
