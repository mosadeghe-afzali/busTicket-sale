<?php

namespace App\Models;

use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    public function companyInfo()
    {
        $this->hasOne(CompanyInfo::class);
    }

    public function getRegistrationDateAttribute($value)
    {
        return $v = Verta::instance($value)->formatDate();
    }
}
