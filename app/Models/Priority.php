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
/**
 * App\Models\Priority
 *
 * @property int $id
 * @property string $title
 * @property string $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task[] $task
 * @property-read int|null $task_count
 * @method static \Illuminate\Database\Eloquent\Builder|Priority newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Priority newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Priority query()
 * @method static \Illuminate\Database\Eloquent\Builder|Priority whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Priority whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Priority whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Priority whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Priority whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
