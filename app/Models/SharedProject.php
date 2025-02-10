<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SharedProject extends Model
{
    protected $table = 'shared_projects';
    protected $fillable = [
        'project_id',
        'user_id',
        'email',
        'permissions',
        'token',
        'expires_at',
    ];

    protected $casts = [
        'permissions' => 'string',
        'expires_at' => 'datetime',
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

