<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Event extends JsonResource
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
            'district' => $this->district,
            'address' => $this->event_address,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'from_time' => $this->from_time,
            'to_time' => $this->to_time,
            'location' => $this->loc_cord,
            'mobile' => $this->mobile_number,
            'website' => $this->website,
            'des_short' => $this->des_short,
            'des_long' => $this->des_long,
            'thumbnail' => $this->thumbnail,
            'likes' => count($this->likes),
            'rating'=> $this->rating,
            'reviews' => Review::collection($this->activeReviews),
            'images' => image::collection($this->images)

        ];
    }
}
