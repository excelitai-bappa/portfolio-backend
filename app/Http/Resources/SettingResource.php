<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
        if($image){
            $image = asset('upload/testimonials/'.$this->image);
        }else{
            $image = NULL;
        }

        return [
            'id' => $this->id,
            'statement'=> $this->statement,
            'name'=> $this->name,
            'designation'=> $this->designation,
            'image'=> $image,
        ];
    }
}
