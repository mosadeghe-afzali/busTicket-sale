<?php

namespace App\repositories;

use App\Models\Company;

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
        $companies = Company::query()->select('name', 'logo')->take(5)->get();

        return $companies;
    }

}
