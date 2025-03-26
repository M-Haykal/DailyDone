<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notes extends Model
{
    use SoftDeletes;

    protected $table = 'notes';

    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
