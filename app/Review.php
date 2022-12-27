<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['reviewable_id', 'reviewable_type', 'body', 'additional_info', 'rating'];

    public function reviewable()
    {
        return $this->morphTo();
    }
}
