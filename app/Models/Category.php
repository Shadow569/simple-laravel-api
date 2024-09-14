<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * @param string $slug
     * @return \App\Models\Category
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public static function getBySlug(string $slug): Category
    {
        return self::where('slug', $slug)->firstOrFail();
    }
}
