<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function project_category()
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }
}
