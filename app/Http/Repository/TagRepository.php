<?php
namespace App\Repository;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;
class TagRepository
{
    public static function getAllTags(): array | null
    {
        $tags = Auth::user()->tags;
        if(count($tags)) { // если у пользователя имеются добавочные теги
            return array_merge($tags, Tag::default()->get());
        } else return Tag::default()->get();
    }
}
