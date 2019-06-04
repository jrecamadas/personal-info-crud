<?php

namespace App\Criterias\LeaveApprover;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchByName implements CriteriaInterface
{
    private $term;

    public function __construct($term)
    {
        $this->term = '%' . str_replace([' ', ','], '', $term) . '%';
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where(function ($query) {
            $query->where('approvers.first_name', 'like', '%' . $this->term . '%')
                  ->orWhere('approvers.last_name', 'like', '%' . $this->term . '%')
                  ->orWhere('approvers.middle_name', 'like', '%' . $this->term . '%')
                  ->orWhereRaw('REPLACE(CONCAT_WS("", `approvers`.`first_name`, `approvers`.`last_name`, `approvers`.`middle_name`), " ", "") LIKE ?', $this->term)
                  ->orWhereRaw('REPLACE(CONCAT_WS("", `approvers`.`first_name`, `approvers`.`middle_name`, `approvers`.`last_name`), " ", "") LIKE ?', $this->term)
                  ->orWhereRaw('REPLACE(CONCAT_WS("", `approvers`.`last_name`, `approvers`.`first_name`, `approvers`.`middle_name`), " ", "") LIKE ?', $this->term)
                  // added this condition to trap two words of their first name
                  ->orWhereRaw('REPLACE(CONCAT_WS("", SUBSTRING_INDEX(`approvers`.`first_name`, " ", 1), `approvers`.`last_name`, `approvers`.`middle_name`), " ", "") LIKE ?', $this->term)
                  ->orWhereRaw('REPLACE(CONCAT_WS("", `approvers`.`last_name`, SUBSTRING_INDEX(`approvers`.`first_name`, " ", 1), `approvers`.`middle_name`), " ", "") LIKE ?', $this->term);
        })
        ->orWhere(function ($query) {
            $query->where('oic.first_name', 'like', '%' . $this->term . '%')
                  ->orWhere('oic.last_name', 'like', '%' . $this->term . '%')
                  ->orWhere('oic.middle_name', 'like', '%' . $this->term . '%')
                  ->orWhereRaw('REPLACE(CONCAT_WS("", `oic`.`first_name`, `oic`.`last_name`, `oic`.`middle_name`), " ", "") LIKE ?', $this->term)
                  ->orWhereRaw('REPLACE(CONCAT_WS("", `oic`.`first_name`, `oic`.`middle_name`, `oic`.`last_name`), " ", "") LIKE ?', $this->term)
                  ->orWhereRaw('REPLACE(CONCAT_WS("", `oic`.`last_name`, `oic`.`first_name`, `oic`.`middle_name`), " ", "") LIKE ?', $this->term)
                  // added this condition to trap two words of their first name
                  ->orWhereRaw('REPLACE(CONCAT_WS("", SUBSTRING_INDEX(`oic`.`first_name`, " ", 1), `oic`.`last_name`, `oic`.`middle_name`), " ", "") LIKE ?', $this->term)
                  ->orWhereRaw('REPLACE(CONCAT_WS("", `oic`.`last_name`, SUBSTRING_INDEX(`oic`.`first_name`, " ", 1), `oic`.`middle_name`), " ", "") LIKE ?', $this->term);
        });
    }
}
