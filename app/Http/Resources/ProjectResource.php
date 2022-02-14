<?php

namespace App\Http\Resources;

use App\Models\ProjectCategory;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $project_thumbnail = $this->project_thumbnail;
        if ($project_thumbnail) {
            $project_thumbnail = asset($this->image);
        } else {
            $project_thumbnail = null;
        }

        $project_image = $this->project_image;
        if ($project_image) {
            $project_image = asset($this->project_image);
        } else {
            $project_image = null;
        }


        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'project_title' => $this->project_title,
            'description' => $this->description,
            'project_thumbnail' => $project_thumbnail,
            'project_image' => $project_image,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'website_url' => $this->website_url,
            'status' => $this->status,
        ];
    }
}
