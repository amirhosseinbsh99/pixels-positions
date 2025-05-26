<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'company',    // if you still keep this field
        'location',
        'category_id',
        'employer_id' // you need this to associate job with user(employer)
    ];

    public function tag(string $name)
    {
        $tag = Tag::firstOrCreate(['name' => $name]);

        if (!$this->tags->contains($tag->id)) {
            $this->tags()->attach($tag);
        }
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // Change employer relation to point to User model where user_type = 'employer'
    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id')
                    ->where('user_type', 'employer');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
