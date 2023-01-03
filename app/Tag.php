<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['tag', 'tag_meta'];

    /**
     * Get all of the accomodations that are assigned this tag.
     */
    public function accomodations()
    {
        return $this->morphedByMany(Accomodation::class, 'taggable');
    }

    /**
     * Get all of the activities that are assigned this tag.
     */
    public function activities()
    {
        return $this->morphedByMany(Activity::class, 'taggable');
    }

    /**
     * Get all of the events that are assigned this tag.
     */
    public function events()
    {
        return $this->morphedByMany(Event::class, 'taggable');
    }

    /**
     * Get all of the foods that are assigned this tag.
     */
    public function foods()
    {
        return $this->morphedByMany(Food::class, 'taggable');
    }

    /**
     * Get all of the tours that are assigned this tag.
     */
    public function tours()
    {
        return $this->morphedByMany(Food::class, 'taggable');
    }

    /**
     * Get all of the destinations that are assigned this tag.
     */
    public function touristDestinations()
    {
        return $this->morphedByMany(TouristDestination::class, 'taggable');
    }
}
