<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employer extends Model
{
    /** @use HasFactory<\Database\Factories\EmployerFactory> */
    use HasFactory;
    protected $fillable = ['user_id'];
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function jobs(){
        return $this->hasMany(Job::class);
    }
}
