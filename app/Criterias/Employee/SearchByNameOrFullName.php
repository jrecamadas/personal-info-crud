<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchByNameOrFullName implements CriteriaInterface
{
    private $term;

    public function __construct($term)
    {
        $this->term = '%' . str_replace([' ', ','], '', $term) . '%';
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where(function ($query) {
            $query->orWhereRaw('REPLACE(CONCAT_WS("", `employees`.`first_name`, `employees`.`last_name`, `employees`.`middle_name`), " ", "") LIKE ?', $this->term)
                  ->orWhereRaw('REPLACE(CONCAT_WS("", `employees`.`first_name`, `employees`.`middle_name`, `employees`.`last_name`), " ", "") LIKE ?', $this->term)
                  ->orWhereRaw('REPLACE(CONCAT_WS("", `employees`.`last_name`, `employees`.`first_name`, `employees`.`middle_name`), " ", "") LIKE ?', $this->term)
                  // added this condition to trap two words of their first name
                  ->orWhereRaw('REPLACE(CONCAT_WS("", SUBSTRING_INDEX(`employees`.`first_name`, " ", 1), `employees`.`last_name`, `employees`.`middle_name`), " ", "") LIKE ?', $this->term)
                  ->orWhereRaw('REPLACE(CONCAT_WS("", `employees`.`last_name`, SUBSTRING_INDEX(`employees`.`first_name`, " ", 1), `employees`.`middle_name`), " ", "") LIKE ?', $this->term);
        });
    }
}