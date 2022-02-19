<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $profile_picture = $this->profile_picture;
        if ($profile_picture) {
            $profile_picture = asset($this->profile_picture);
        } else {
            $profile_picture = null;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone ,
            'profile_picture' => $profile_picture,
            'password' => $this->password,
            'status' => $this->status,
        ];
    }
}
