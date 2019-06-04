<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class FilterByName implements CriteriaInterface
{
    private $firstName;
    private $lastName;

    public function __construct($firstName, $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where(function($query){
            return $query->where('employees.first_name', '=', $this->firstName)
                ->where('employees.last_name', '=', $this->lastName);
        });
    }
}
