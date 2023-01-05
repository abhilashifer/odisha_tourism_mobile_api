<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Accomodation extends JsonResource
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
            'district'=> $this->district,
            'category' => $this->category,
            'thumbnail' => $this->thumbnail,
            'address' => $this->address,
            'des_short' => $this->des_short,
            'likes' => count($this->likes),
            'rating' => $this->rating,
            'tags' =>Tag::collection($this->tags)
        ];
    }
}
