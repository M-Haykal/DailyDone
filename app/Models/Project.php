<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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

    public function sharedProjects()
    {
        return $this->hasMany(SharedProject::class);
    }

    public function sharedUsers()
    {
        return $this->belongsToMany(User::class, 'shared_projects', 'project_id', 'user_id')
                    ->withPivot('id', 'permissions', 'token', 'email')
                    ->withTimestamps();
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id');
    }     
    
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($project) {
            $project->slug = Str::slug($project->name) . '-' . Str::random(6);
        });
    }
}
