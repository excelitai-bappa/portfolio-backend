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
            $project_thumbnail = asset($this->project_thumbnail);
        } else {
            $project_thumbnail = null;
        }

        return [
            'id' => $this->id,
            'category_id' => $this->project_category->name,
            'project_title' => $this->project_title,
            'description' => $this->description,
            'project_thumbnail' => $project_thumbnail,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'website_url' => $this->website_url,
            'status' => $this->status,
        ];
    }
}
