<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';

    protected $fillable = ['master_subcategory_id', 'name', 'food_type', 'thumbnail', 'des_short', 'des_long'];

    /**
     * Retrieving subcategory
     */
    public function category()
    {
        return MasterSubcategory::where('id', '=', $this->master_subcategory_id)->first()->value('name');
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
        return $this->morphMany('App\Like', 'likeable');
    }
    /**
     * Retrieving rating
     */
    public function rating()
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
        return $this->morphToMany(Tag::class, 'taggable');
    }
    /**
     * Get rating for a single food.
     */
    public static function ratingByFoodId($foodId)
    {
        $rating = self::where('id', '=', $foodId)->first()->rating();
        return $rating;
    }
    /**
     * Get all of the tags for the food.
     */
    public static function sortByRating($dis)
    {

        $foods = self::orderBy('id', 'desc')->limit(10)->get();
        foreach ($foods as $val) {
            $val['rating'] = self::ratingByFoodId($val->id);
            unset($val->des_long);
        }
        // array_map(function ($a) {
        //     $a['rating'] = self::ratingByFoodId($a->id);
        // }, $foods);
        // usort($foods, fn ($a, $b) => $a['rating'] <=> $b['rating']);
        return $foods;
    }
}
