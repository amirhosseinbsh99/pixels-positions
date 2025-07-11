<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_DENIED = 'denied';

    protected $fillable = ['user_id', 'cover_letter', 'status'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
    
}
