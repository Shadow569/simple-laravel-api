<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    const DEFAULT_TAGS = [
        [
            'identifier' => 'new',
            'name' => 'New'
        ],
        [
            'identifier' => 'edited',
            'name' => 'Edited'
        ],
        [
            'identifier' => 'recently-updated',
            'name' => 'Recently modified'
        ]
    ];


    /**
     * Seed the categories.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::DEFAULT_TAGS as $tag){
            if(empty(Tag::where('identifier', $tag['identifier'])->first())){
                Tag::create($tag);
            }
        }
    }
}
