<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Tour extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'district' => $this->district(),
            'tour_from' => $this->tour_from,
            'tour_to' => $this->tour_to,
            'destinations' => TouristDestination::collection($this->touristDestinations),
            'location' => $this->loc_cord,
            'des_short' => $this->des_short,
            'des_long' => $this->des_long,
            'additional_info' => $this->additional_info,
            'likes' => count($this->likes),
            'reviews' => Review::collection($this->activeReviews),
            'images' => Image::collection($this->images)

        ];
    }
}
