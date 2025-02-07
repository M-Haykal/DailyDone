<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskList extends Model
{
    protected $table = 'task_lists';
    
    protected $fillable = [
        'list_items',
        'detail_list',
        'status',
        'priority',
        'tag',
        'note',
        'project_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
