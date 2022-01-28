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
/**
 * App\Models\Tag
 *
 * @property int $id
 * @property string $color
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task[] $task
 * @property-read int|null $task_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Tag default()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'color', 'title'
    ];

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
