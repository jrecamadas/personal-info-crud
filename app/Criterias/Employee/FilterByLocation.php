<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class FilterByLocation implements CriteriaInterface
{
    private $city;
    private $country;

    public function __construct($city, $country)
    {
        $this->city = $city;
        $this->country = $country;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where(function($query){
            return $query->where('employee_locations.city', '=', $this->city)
                ->where('employee_locations.country', '=', $this->country);
        });
    }
}
