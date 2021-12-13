<?php

namespace App\Models;

use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    protected  $guarded = ['id'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function getDateAttribute($value)
    {
        return $v = Verta::instance($value)->formatDatetime();
    }

    public function getEndDateAttribute($value)
    {
        return $v = Verta::instance($value)->formatDatetime();
    }

    public function setDateAttribute($value)
    {
        $v = Verta::parse($value);
         $this->attributes['date'] = Carbon::instance($v->datetime())->format('Y-m-d H:i:s');
    }

    public function setEndDateAttribute($value)
    {
        $v = Verta::parse($value);
         $this->attributes['end_date'] = Carbon::instance($v->datetime())->format('Y-m-d H:i:s');
    }

    public function scopeFilter($query, $filter, $order)
    {
        return $query->when($filter ?? false,
            fn($query) => $query->orderBy($filter, $order),
            fn($query) => $query->orderBy('date', 'asc')
        );
    }

    public function scopeScheduleVehicle($query)
    {
        return $query->join('vehicles', 'schedules.vehicle_id', '=', 'vehicles.id');
    }

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

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

}
