<?php

namespace App\Models;

use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return $v = Verta::instance($value)->formatDatetime();
    }

    public function scopeCommentCompany($query, $select)
    {
        $company_callback = function ($query) use ($select) {
            $query->select($select);
        };
        return $query->select( 'content', 'company_id', 'created_at')->with(['company' => $company_callback]);
    }


}
