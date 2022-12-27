<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravellerExperience extends Model
{
    protected $fillable = ['thumbnail', 'media_data', 'active'];

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }
}
