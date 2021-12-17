<?php

namespace App\Models;

use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    /**
     * get user associated with company.
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * get vehicles of a company.
     *
     */
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    /**
     * get the company's comment.
     *
     */
    public function comment()
    {
        return $this->hasOne(Comment::class);
    }

    /**
     * get company information.
     *
     */
    public function companyInfo()
    {
        return $this->hasOne(CompanyInfo::class);
    }

    /**
     * get company registration date in terms of solar date.
     *
     * @param $value
     * @return string
     */
    public function getRegistrationDateAttribute($value)
    {
        return $v = Verta::instance($value)->formatDate();
    }
}
