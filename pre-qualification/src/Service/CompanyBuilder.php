<?php

declare(strict_types=1);

namespace Service;

use Entity\Address;
use Entity\Company;

class CompanyBuilder
{
    public function createCompany(array $data): Company
    {
        $c = new Company();
        $c->id = $data['id'];
        $c->creator = $data['creator'];
        $c->name = $data['name'];

        return $c;
    }
}
