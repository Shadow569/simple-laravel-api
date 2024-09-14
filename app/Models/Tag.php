<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'identifier',
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * @param string $identifier
     * @return \App\Models\Tag
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public static function findByIdentifier(string $identifier): Tag
    {
        return self::where('identifier', $identifier)->firstOrFail();
    }
}
