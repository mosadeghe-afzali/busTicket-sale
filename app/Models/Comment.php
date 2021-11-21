<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function scopeCommentCompany($query, $select)
    {
        $company_callback = function ($query) use ($select) {
            $query->select($select);
        };
        return $query->select( 'content', 'company_id')->with(['company' => $company_callback]);
    }
}
