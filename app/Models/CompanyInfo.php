<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyInfo extends Model
{
    use HasFactory;

    /**
     * get company.
     *
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
