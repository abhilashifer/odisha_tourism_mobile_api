<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MajorCity extends JsonResource
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
            // 'district' => $this->district(),
            // 'des_short' => $this->des_short,
            'thumbnail' => $this->thumbnail,
            'images' => Image::collection($this->images)
        ];
    }
}
