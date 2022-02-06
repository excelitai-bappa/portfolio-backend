<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
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
            $image = asset('upload/teams/'.$this->image);
        }else{
            $image = NULL;
        }

        return [
            'id' => $this->id,
            'name'=> $this->name,
            'designation'=> $this->designation,
            'fb_url'=> $this->fb_url,
            'twitter_url'=> $this->twitter_url,
            'linkedin_url'=> $this->linkedin_url,
            'insta_url'=> $this->insta_url,
            'image'=> $image,
        ];
    }
}
