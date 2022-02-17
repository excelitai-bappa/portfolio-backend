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
        $logo = $this->logo;
        if ($logo) {
            $logo = asset($this->logo);
        } else {
            $logo = null;
        }
        $favicon = $this->favicon;
        if ($favicon) {
            $favicon = asset($this->favicon);
        } else {
            $favicon = null;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'short_description' => $this->short_description,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'address' => $this->address,
            'fb_link' => $this->fb_link,
            'twitter_link' => $this->twitter_link,
            'linekdin_link' => $this->linekdin_link,
            'logo' => $logo,
            'favicon' => $favicon,
        ];
    }
}
