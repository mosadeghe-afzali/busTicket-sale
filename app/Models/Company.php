<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function comment()
    {
        return $this->hasOne(Comment::class);
    }





}
