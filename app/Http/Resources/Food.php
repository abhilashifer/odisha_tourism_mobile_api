<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Food extends JsonResource
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
            'category' => $this->master_subcategory_name,
            'type' => $this->food_type,
            'thumbnail' => $this->thumbnail,
            'des_short' => $this->des_short,
            'likes' => count($this->likes),
            'rating' => $this->rating,
            'reviews' => count($this->reviews),
        ];
    }
}
