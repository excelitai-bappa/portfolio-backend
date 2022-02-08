<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SlidersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $image = $this->image;
        if ($image) {
            $image = asset($this->image);
        } else {
            $image = null;
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'short_description' => $this->short_description,
            'image' => $image,
            'status' => $this->status,
        ];
    }
}
