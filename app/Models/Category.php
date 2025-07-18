<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Category extends Model
{
    use HasFactory;
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    
}
