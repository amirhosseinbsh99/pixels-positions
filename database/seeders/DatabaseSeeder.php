<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Call other seeders if you have
        $this->call([
            JobSeeder::class,
            CategorySeeder::class,
        ]);

        // Create an employer user
        $employer = User::create([
            'name' => 'amirhossein bsh',
            'email' => 'amirhosseinbsh99@gmail.com',
            'bio' => 'mid lvl backend developer',
            'password' => Hash::make('123456'),
            'email_verified_at' => Carbon::now(),
            'user_type' => 'employer',
            'logo' => 'images/default-user.png',  // store relative path or wherever you keep logos
        ]);

        // Create a category for the job
        $category = \App\Models\Category::create(['name' => 'Programming']);

        // Create a job related to the employer user
        Job::create([
            'employer_id' => $employer->id,  // now employer_id references users.id
            'category_id' => $category->id,
            'title' => 'Backend Developer',
            'salary' => '10000',
            'location' => 'Iran',
            'schedule' => 'Part Time',
            'url' => 'https://github.com/amirhosseinbsh99',
        ]);

        // Seed other data if needed again
        $this->call([
            JobSeeder::class,
            CategorySeeder::class,
            UserTagSeeder::class
        ]);
    }
}
