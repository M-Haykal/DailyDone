<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusTask extends Model
{
    protected $table = 'status_tasks';

    protected $fillable = [
        'name',
        'description',
        'project_id',
        'user_id',
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
