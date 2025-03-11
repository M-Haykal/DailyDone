<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackgroundProjects extends Model
{
    protected $table = 'background_projects';

    protected $fillable = [
        'image_project',
        'project_id'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
