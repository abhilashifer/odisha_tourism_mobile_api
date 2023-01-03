<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MasterSubcategory extends JsonResource
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
            'category' => new MasterCategory($this->masterCategory),
            'thumbnail' => $this->thumbnail,
            'des_short' => $this->description,
            'active' => $this->active
        ];
    }
}
