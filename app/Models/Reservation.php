<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    public function passenger()
    {
        return $this->belongsTo(Passenger::class);
    }
}