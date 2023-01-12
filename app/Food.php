<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Food extends Model
{
    use Searchable;

    protected $table = 'foods';

    protected $fillable = ['master_subcategory_id', 'name', 'food_type', 'thumbnail', 'des_short', 'des_long'];

    protected $appends =['master_subcategory_name','rating'];

    /**
     * Retrieving subcategory
     */
    public function getMasterSubcategoryNameAttribute()
    {
        return MasterSubcategory::where('id', '=', $this->master_subcategory_id)->value('name');
    }

    /**
     * Retrieving images
     */
    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }
    /**
     * Retrieving reviews
     */
    public function reviews()
    {
        return $this->morphMany('App\Review', 'reviewable');
    }
    /**
     * Retrieving active reviews
     */
    public function activeReviews()
    {
        return $this->morphMany('App\Review', 'reviewable')->where('status','=',1);
    }
    /**
     * Retrieving likes
     */
    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable')->select();
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
    /**
     * Get all of the tags for the food.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable')->select('id','tag');
    }

    public static function sortByRating()
    {


    }
}
