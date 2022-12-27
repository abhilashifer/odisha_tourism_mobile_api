<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
  protected $fillable = ['master_subcategory_id', 'district_id', 'name', 'event_address', 'from_date', 'to_date', 'from_time', 'to_time', 'loc_cord', 'mobile_number', 'website', 'des_short', 'des_long', 'thumbnail'];

  public function subcategory()
  {
    return $this->belongsTo('App\MasterSubcategory');
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
