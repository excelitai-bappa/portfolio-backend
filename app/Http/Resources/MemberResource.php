<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $image = $this->profile_picture;
        if($image){
            $image = asset('upload/users_images/'.$this->profile_picture);
        }else{
            $image = NULL;
        }
        return [
            'id' => $this->id,
            'member_id'=> $this->member_id,
            'name'=> $this->name,
            'gender'=> $this->gender,
            'mobile'=> $this->mobile,
            'blood_group'=> $this->blood_group,
            'address'=> $this->address,
            'user'=>$this->user,
            'invoices' => $this->invoices,

            'profile_picture'=> $image,

            'start_date'=> $this->start_date,
            'end_date'=> $this->end_date,
            'card_no'=> $this->card_no,
            'status'=> $this->status,
        ];
    }






}
