<?php

namespace App\Search;

use Algolia\ScoutExtended\Searchable\Aggregator;

class Tourism extends Aggregator
{
    /**
     * The names of the models that should be aggregated.
     *
     * @var string[]
     */
    protected $models = [
        \App\Event::class,
        \App\Accomodation::class,
        \App\Activity::class,
        \App\Food::class,
        \App\MajorCity::class,
        \App\Tour::class,
        \App\TouristDestination::class
    ];
}
