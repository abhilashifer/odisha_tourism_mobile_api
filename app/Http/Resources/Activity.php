<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Activity extends JsonResource
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
            'category' => new MasterSubcategory($this->subcategory),
            'des_short' => $this->des_short,
            'des_long' => $this->des_long,
            'thumbnail' => $this->thumbnail,
            'location' => $this->loc_cord,
            'reviews' => Review::collection($this->activeReviews),
            'likes' => count($this->likes()),
            'images' => Image::collection($this->images)
        ];
    }
}
