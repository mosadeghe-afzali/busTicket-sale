<?php

namespace App\Models;

use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    /**
     * get the company that left the comment.
     *
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * get creation date in terms of solar date.
     *
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return  Verta::instance($value)->formatDatetime();
    }

    /**
     * scope a query to get comment's company.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param $select
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCommentCompany($query, $select)
    {
        $company_callback = function ($query) use ($select) {
            $query->select($select);
        };
        return $query->select( 'content', 'company_id', 'created_at')->with(['company' => $company_callback]);
    }
}
