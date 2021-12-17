<?php

namespace App\repositories;

use App\Models\Company;
use App\Models\CompanyInfo;

class CompanyRepository
{
    /**
     * get company_id.
     *
     * @param string $name
     * @return int $id
     */
    public function companyId($name)
    {
        return Company::where('name', $name)->value('id');
    }

    /**
     * fetch list of companies in database.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function list()
    {
        return Company::query()->select('name', 'logo', 'registration_date')->take(5)->get();
    }

    /**
     * get company info.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function info()
    {
        return CompanyInfo::query()->select('about_us', 'company_id')->with(['company' => function ($query) {
            $query->select('registration_date', 'id');
        }])->get();
    }
}
