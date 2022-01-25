<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
enum PriorityColors : string {
    case NO_PRIORITY = 'gray';
    case LOW = 'green';
    case MEDIUM = '#e8ce68';
    case HIGH = 'red';
}
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
