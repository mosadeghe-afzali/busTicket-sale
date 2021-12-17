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

    /**
     * The attributes that are not mass assignable.
     *
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * get passenger of a reservation.
     *
     */
    public function passenger()
    {
        return $this->belongsTo(Passenger::class);
    }

    /**
     * get schedule associated to a reservation.
     *
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * get user who done a reservation.
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * scope a query to ger schedule data of a reservation.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param $select
     * @return \Illuminate\Database\Eloquent\Builder
     */
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

    /**
     * scope a query to get passenger data of a reservation.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param $select
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCheckPassenger($query, $select)
    {
        $passenger_callback = function ($query) use ($select) {
            $query->select($select);
        };

        return $query->with(['passenger' => $passenger_callback]);
    }
}


