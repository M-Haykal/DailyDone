<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Project extends Model
{
    use SoftDeletes;

    protected $table = 'projects';
    
    protected $fillable = [
        'name',
        'description',
        'note',
        'background_project',
        'status',
        'archived_at',
        'archived_by',
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
        return $this->hasMany(TaskList::class, 'project_id')->withTrashed();
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

        // Ketika project di-soft delete, soft delete juga tasklist-nya
        static::deleting(function ($project) {
            if ($project->isForceDeleting()) {
                // Jika hard delete, lakukan sesuatu (opsional)
            } else {
                // Jika soft delete, soft delete juga tasklist-nya
                $project->taskLists()->delete();
            }
        });

        // Ketika project di-restore, restore juga tasklist-nya
        static::restored(function ($project) {
            $project->taskLists()->withTrashed()->restore();
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    
    public function scopeArchived($query) {
        return $query->where('status', 'archived');
    }
    
    public function archive()
    {
        $this->update([
            'status' => 'archived',
            'archived_at' => now(),
            'archived_by' => Auth::id()
        ]);
    }
    
    public function activate()
    {
        $this->update([
            'status' => 'active',
            'archived_at' => null,
            'archived_by' => null
        ]);
    }

    public function progress()
    {
        $total = $this->taskLists()->count();
        if ($total == 0) return 0;
        
        return round(($this->taskLists()->where('status', 'completed')->count() / $total) * 100);
    }
}

