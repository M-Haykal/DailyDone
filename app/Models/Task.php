<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'name',
        'project_id',
        'user_id',
    ];

    protected $dates = ['deleted_at'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function taskLists()
    {
        return $this->hasMany(TaskList::class);
    }
}
