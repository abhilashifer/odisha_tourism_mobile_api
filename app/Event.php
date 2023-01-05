<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Event extends Model
{
  protected $fillable = ['master_subcategory_id', 'district_id', 'name', 'event_address', 'from_date', 'to_date', 'from_time', 'to_time', 'loc_cord', 'mobile_number', 'website', 'des_short', 'des_long', 'thumbnail'];
  protected $appends = ['category','district','rating'];
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
   * Retrieving likes obj
   */
  public function likes()
  {
    return $this->morphMany('App\Like', 'likeable');
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
   * Retrieving images obj
   */
  public function images()
  {
    return $this->morphMany('App\Image', 'imageable');
  }
    /**
     * Get all of the tags for the event.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable')->select('id','tag');
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
     * Get all today's events.
     */
    public static function todayEvents()
    {
        return self::where('from_date', Carbon::today()->format('Y-m-d'))->get();
    }
    /**
     * Get all tomorrow's events.
     */
    public static function tomorrowEvents()
    {
        return self::where('from_date', Carbon::tomorrow()->format('Y-m-d'))->get();
    }
    /**
     * Get all next weeks's events.
     */
    public static function nextWeekEvents()
    {
        $date_from = Carbon::today()->format('Y-m-d');
        $date_from = date_add(date_create($date_from),date_interval_create_from_date_string("4 days"));
        $date_from = date_format($date_from,'Y-m-d');
        $date_to = date_add(date_create($date_from),date_interval_create_from_date_string("6 days"));
        $date_to = date_format($date_to,'Y-m-d');
        return self::whereBetween('from_date',[$date_from,$date_to])->get();

    }
    /**
     * Get all one month's events.
     */
    public static function thisMonthEvents()
    {
        $date_from = Carbon::today()->format('Y-m-d');
        $date_to = date_add(date_create($date_from),date_interval_create_from_date_string("30 days"));
        $date_to = date_format($date_to,'Y-m-d');
        return self::whereBetween('from_date',[$date_from,$date_to])->get();
    }
    /**
     * Get all categorised events.
     */
//    public static function sortedEvents()
//    {
//        $data = DB::table('events')->groupBy('master_subcategory_id')->get();
//        return \App\Http\Resources\Event::collection($data);
//    }

}
