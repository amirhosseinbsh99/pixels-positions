<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Job;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    // Create tags
    $tags = Tag::factory(3)->create();

    // Create categories
    $categories = Category::factory(5)->create();

    // Create jobs without category association first
    $jobs = Job::factory(20)
        ->hasAttached($tags) // Attach tags to the jobs during creation
        ->state(new Sequence(
            ['featured' => false, 'schedule' => 'Full Time'],
            ['featured' => true, 'schedule' => 'Part Time']
        ))
        ->create();

    // Assign a random category to each job
    $jobs->each(function ($job) use ($categories) {
        \Log::info('Assigning category to job: '.$job->id);
        $job->category()->associate($categories->random());
        $job->save();
    });
}

}
