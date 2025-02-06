<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SharedProject extends Model
{
    protected $table = 'shared_projects';
    protected $fillable = [
        'project_id',
        'user_id',
        'permissions',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
