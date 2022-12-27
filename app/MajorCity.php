<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class MajorCity extends Model
{


    protected $fillable = ['name', 'district_id', 'desc_short', 'thumbnail'];

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }
}
