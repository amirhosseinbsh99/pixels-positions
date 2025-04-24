<?php

namespace Database\Seeders;

use App\Models\Employer;
use App\Models\Job;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            JobSeeder::class,
            CategorySeeder::class,
        ]);
        User::create([
            'name' => 'amirhossein bsh',
            'email' => 'amirhosseinbsh99@gmail.com', 
            'bio' => 'mid lvl backend developer',
            'password' => Hash::make('123456'), 
            'email_verified_at' => Carbon::now(),
        ]);
        Employer::create([
            'name' => 'amirhossein bsh',
            'email' => 'amirhosseinbsh99@gmail.com', 
            'bio' => 'mid lvl backend developer',
            'password' => Hash::make('123456'), 
            'email_verified_at' => Carbon::now(),
        ]);
        Job::create([
            'title' => 'Backend Developer',
            'salary' => '10,000$ usd ', 
            'location' => 'Iran',
            'schedule' => 'Part Time', 
            'url' => 'https://github.com/amirhosseinbsh99',
            'category' => 'cum',
            'tag' => 'Programmer'
            

        ]);
    }
}
