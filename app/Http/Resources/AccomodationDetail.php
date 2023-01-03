<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccomodationDetail extends JsonResource
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
            'category' => $this->category(),
            'district' => $this->district(),
            'thumbnail' => $this->thumbnail,
            'address' => $this->address,
            'des_short' => $this->des_short,
            'des_long' => $this->des_long,
            'location' => $this->loc_cord,
            'mobile' => $this->mobile_number,
            'email' => $this->email,
            'website' => $this->website,
            'reviews' => Review::collection($this->activeReviews),
            'likes' => count($this->likes),
            'rating' => $this->rating(),
            'images' => Image::collection($this->images),
            'tags'=> Tag::collection($this->tags)
        ];
    }
}
