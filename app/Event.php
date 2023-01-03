<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Event extends Model
{
  protected $fillable = ['master_subcategory_id', 'district_id', 'name', 'event_address', 'from_date', 'to_date', 'from_time', 'to_time', 'loc_cord', 'mobile_number', 'website', 'des_short', 'des_long', 'thumbnail'];

  /**
   * Retrieving district name
   */
  public function district()
  {
    return DB::table('t_district')->select('vchDistrictName')->where('intDistrictId', $this->district_id)->value('vchDistrictName');
  }
  /**
   * Retrieving subcategory obj
   */
  public function subcategory()
  {
    return $this->belongsTo('App\MasterSubcategory');
  }
  /**
   * Retrieving likes obj
   */
  public function likes()
  {
    return $this->morphMany('App\Like', 'likeable');
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
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
