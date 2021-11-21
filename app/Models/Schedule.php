<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
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
        return $query->where(DB::raw('DATE(date)'), $data['date'])->where('origin', $data['origin'])
            ->where('destination', $data['destination'])->select('date', 'origin', 'destination', 'price',
                'vehicles.capacity', 'vehicles.model', 'vehicles.description');
    }

}
