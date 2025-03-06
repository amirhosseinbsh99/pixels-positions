<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    /** @use HasFactory<\Database\Factories\JobFactory> */
    use HasFactory;

    protected $fillable = ['title', 'company', 'location', 'category_id'];
    public function tag(string $name)
    {
        // Ensure the tag exists or create it
        $tag = Tag::firstOrCreate(['name' => $name]);

        // Attach the tag to the job if it is not already attached
        if (!$this->tags->contains($tag->id)) {
            $this->tags()->attach($tag);
        }
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function employer(){
        return $this->belongsTo(Employer::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}