<?php

namespace App\Models;

use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    /**
     * The attributes that are not mass assignable.
     *
     * @var string[]
     */
    protected  $guarded = ['id'];

    /**
     * get vehicle of a schedule.
     *
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * display schedule date in terms of solar date.
     *
     * @param $value
     * @return string
     */
    public function getDateAttribute($value)
    {
        return $v = Verta::instance($value)->formatDatetime();
    }

    /**
     * display schedule end_date in terms of solar date.
     *
     * @param $value
     * @return string
     */
    public function getEndDateAttribute($value)
    {
        return $v = Verta::instance($value)->formatDatetime();
    }

    /**
     * set schedule date as Gregorian date.
     *
     * @param $value
     */
    public function setDateAttribute($value)
    {
        $v = Verta::parse($value);
        $this->attributes['date'] = Carbon::instance($v->datetime())->format('Y-m-d H:i:s');
    }

    /**
     * set schedule end_date as Gregorian date in database.
     *
     * @param $value
     */
    public function setEndDateAttribute($value)
    {
        $v = Verta::parse($value);
         $this->attributes['end_date'] = Carbon::instance($v->datetime())->format('Y-m-d H:i:s');
    }

    /**
     * scope a query to order schedules in terms of a specific filter.
     *
     * @param Builder $query
     * @param string $filter
     * @param string $order
     * @return Builder
     */
    public function scopeFilter($query, $filter, $order)
    {
        return $query->when($filter ?? false,
            fn($query) => $query->orderBy($filter, $order),
            fn($query) => $query->orderBy('date', 'asc')
        );
    }

    /**
     * scope a query to select schedule's vehicle.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeScheduleVehicle($query)
    {
        return $query->join('vehicles', 'schedules.vehicle_id', '=', 'vehicles.id');
    }

    /**
     * scope a query to  only include a specific date, origin and destination.
     *
     * @param  Builder  $query
     * @param array $data
     * @return Builder
     */
    public function scopeScheduleSelection($query, $data)
    {
        return $query->where(DB::raw('DATE(date)'), $data['date'])
            ->when($data['origin'] ?? false,
                fn($query) => $query->where('origin', $data['origin']))->
            when($data['destination'] ?? false,
                fn($query) => $query->where('destination', $data['destination']))->
            select('date', 'end_date', 'origin', 'destination', 'price',
                'remaining_capacity', 'vehicles.model', 'vehicles.description');
    }

    /**
     * get an schedule's reservations.
     *
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
