<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use Notifiable;
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    public function passenger()
    {
        return $this->belongsTo(Passenger::class);
    }
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeCheckSchedule($query, $select)
    {
        $company_callback = function ($query){
            $query->select('id', 'name');
        };

        $vehicle_callback = function ($query) use ($company_callback) {
            $query->select('model', 'id', 'company_id')->with(['company' => $company_callback]);
        };

        $schedule_callback = function ($query) use ($select, $vehicle_callback) {
            $query->select($select)->with(['vehicle' => $vehicle_callback] );
        };

        return $query->with(['schedule' => $schedule_callback]);
    }

    public function scopeCheckPassenger($query, $select)
    {
        $passenger_callback = function ($query) use ($select) {
            $query->select($select);
        };

        return $query->with(['passenger' => $passenger_callback]);
    }
}


