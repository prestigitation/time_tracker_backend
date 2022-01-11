<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public function priority()
    {
        return $this->hasOne(Priority::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
}
