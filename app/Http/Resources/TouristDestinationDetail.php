<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TouristDestinationDetail extends JsonResource
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
            'trip_type' => $this->trip_type,
            'category' => $this->category(),
            'address' => $this->address,
            'district' => $this->district(),
            'thumbnail' => $this->thumbnail,
            'des_short' => $this->des_short,
            'des_long' => $this->des_long,
            'likes' => count($this->likes),
            'rating'=>$this->rating(),
            'reviews'=> Review::collection($this->activeReviews),
            'images' => Image::collection($this->images),
            'tags'=> Tag::collection($this->tags)
        ];
    }
}
