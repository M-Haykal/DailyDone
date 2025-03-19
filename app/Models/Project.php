<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $table = 'projects';
    
    protected $fillable = [
        'name',
        'description',
        'note',
        'background_project',
        'start_date',
        'end_date',
        'user_id',
    ];
    
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function taskLists()
    {
        return $this->hasMany(TaskList::class, 'project_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sharedUsers()
    {
        return $this->belongsToMany(User::class, 'shared_projects', 'project_id', 'user_id')
                    ->withPivot('permissions')
                    ->withTimestamps();
    }
    

}
