<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
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
            'statement' => $this->statement,
            'name' => $this->name,
            'designation' => $this->designation,
            'image' => $image,
            'status' => $this->status,
        ];
    }
}
