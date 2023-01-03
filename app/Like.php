<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['likeable_type', 'likeable_id', 'user_id'];

    /**
     * Get the owning commentable model.
     */
    public function likeable()
    {
        return $this->morphTo();
    }
    /**
     * Get the like owner.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
