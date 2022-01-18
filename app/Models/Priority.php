<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    use HasFactory;

    public function task()
    {
        return $this->belongsToMany(Task::class);
    }

    protected $hidden = [
        'priority_id'
    ];
}
