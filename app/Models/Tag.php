<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /** @use HasFactory<\Database\Factories\TagFactory> */
    use HasFactory;

    public function jobs(){
        return $this->belongsToMany(Job::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
