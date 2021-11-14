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

}
