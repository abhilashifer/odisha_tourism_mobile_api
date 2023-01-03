<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['reviewable_id', 'reviewable_type', 'body', 'additional_info', 'rating', 'user_id','status'];

    /**
     * Get the reviewable model.
     */
    public function reviewable()
    {
        return $this->morphTo();
    }
    /**
     * Get the review owner.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
