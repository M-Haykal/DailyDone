<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskList extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'task_lists';
    
    protected $fillable = [
        'list_items',
        'detail_list',
        'status',
        'priority',
        'tag',
        'note',
        'start_date',
        'end_date',
        'project_id',
        'task_id',
        'user_id',
    ];

    protected $dates = ['deleted_at'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'tasklist_user', 'tasklist_id', 'user_id');
    }    

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}

