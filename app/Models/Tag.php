<?php

namespace App\Models\Tag;

enum DefaultTags : string {
    case URGENT = 'red';
    public function name()
    {
        return match($this) {
            static::URGENT => 'Cрочная задача'
        };
    }
}

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Tag extends Model
{
    use HasFactory;

    public function task()
    {
        return $this->belongsToMany(Task::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function scopeDefault($query)
    {
        $defaultLabels = array_map(
            fn(Tag\DefaultTags $tag) => $tag->name(),
            Tag\DefaultTags::cases()
        );
        $query->whereIn('title', $defaultLabels);
    }
}
