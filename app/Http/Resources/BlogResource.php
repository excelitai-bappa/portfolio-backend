<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $blog_thumbnail = $this->blog_thumbnail;
        if ($blog_thumbnail) {
            $blog_thumbnail = asset($this->blog_thumbnail);
        } else {
            $blog_thumbnail = null;
        }

        return [
            'id' => $this->id,
            'blog_category_id' => $this->blog_category->name,
            'created_by' => $this->created_by,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'blog_thumbnail' => $blog_thumbnail,
            'status' => $this->status,
        ];
    }
}
