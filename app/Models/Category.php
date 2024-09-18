<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'parent_id',
        'slug',
        'title'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
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
