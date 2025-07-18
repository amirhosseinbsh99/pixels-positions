<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tag;

class UserTagSeeder extends Seeder
{
    public function run()
    {
        // Create some tags (or find existing ones)
        $tags = ['backend developer', 'DRF', 'RESTful', 'Laravel', 'Django'];

        $tagIds = [];
        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $tagIds[] = $tag->id;
        }

        // Attach tags to users (for example, user with ID 1 and 2)
        $user1 = User::find(1);
        $user2 = User::find(2);

        if ($user1) {
            $user1->tags()->sync($tagIds);  // Assign all tags to user 1
        }

        if ($user2) {
            $user2->tags()->sync(array_slice($tagIds, 0, 3));  // Assign first 3 tags to user 2
        }
    }
}
