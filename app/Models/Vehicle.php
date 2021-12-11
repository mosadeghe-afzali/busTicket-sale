<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded = ['id'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }
}
