<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    const DEFAULT_CATEGORIES = [
        [
            'slug' => 'popular-posts',
            'title' => 'Popular Posts'
        ],
        [
            'slug' => 'new-posts',
            'title' => 'New Posts'
        ],
        [
            'slug' => 'breaking-news',
            'title' => 'Breaking News'
        ]
    ];


    /**
     * Seed the categories.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::DEFAULT_CATEGORIES as $category){
            if(empty(Category::where('slug', $category['slug'])->first())){
                Category::create($category);
            }
        }
    }
}
