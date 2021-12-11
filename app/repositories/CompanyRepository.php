<?php

namespace App\repositories;

use App\Models\Company;
use App\Models\CompanyInfo;

class CompanyRepository
{
    /*get company_id */
    public function companyId($name)
    {
        $id = Company::where('name', $name)->value('id');

        return $id;
    }

    /* fetch list of companies in database */
    public function list()
    {
        $companies = Company::query()->select('name', 'logo', 'registration_date')->take(5)->get();

        return $companies;
    }

    public function info()
    {
        $info = CompanyInfo::query()->select('about_us', 'company_id')->with(['company' => function ($query) {
            $query->select('registration_date', 'id');
        }])->get();

        return $info;
    }

}
