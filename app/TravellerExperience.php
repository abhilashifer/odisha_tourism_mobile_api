<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravellerExperience extends Model
{
    protected  $primaryKey = 'id';
    protected $fillable = ['thumbnail', 'media_data', 'active'];

    /**
     * Get the media.
     *
     * @return string
     */
//    public function getMediaDataAttribute()
//    {
//        return json_decode($this->media_data,true);
//    }

    /**
     *Getting travellers' experince images
     */
    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }
}
