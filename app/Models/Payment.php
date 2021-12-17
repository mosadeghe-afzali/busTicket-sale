<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are not mass assignable.
     *
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * get reservation data of a payment.
     *
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * get user who done payment.
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
