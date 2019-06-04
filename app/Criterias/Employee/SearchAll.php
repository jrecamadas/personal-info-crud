<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchAll implements CriteriaInterface
{
    private $trimmed;
    private $term;

    public function __construct($term)
    {
        $this->trimmed =  str_replace([' ', ','], '', $term);
        $this->term = $term;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $search = array('\\','%','_','*',"'",'"');
        $replace = array('\\\\\\','\%','\_','\*',"\'",'\"');
        $this->trimmed = '%' . str_replace($search, $replace, $this->trimmed) . '%';
        $this->term = str_replace($search, $replace, $this->term);
        //
        return $model->where(function ($query) {
            $query->orWhereRaw('REPLACE(CONCAT_WS("", `employees`.`first_name`, `employees`.`last_name`, `employees`.`middle_name`), " ", "") LIKE ?', $this->trimmed)
                ->orWhereRaw('REPLACE(CONCAT_WS("", `employees`.`first_name`, `employees`.`middle_name`, `employees`.`last_name`), " ", "") LIKE ?', $this->trimmed)
                ->orWhereRaw('REPLACE(CONCAT_WS("", `employees`.`last_name`, `employees`.`first_name`, `employees`.`middle_name`), " ", "") LIKE ?', $this->trimmed)
                // added this condition to trap two words of their first name
                ->orWhereRaw('REPLACE(CONCAT_WS("", SUBSTRING_INDEX(`employees`.`first_name`, " ", 1), `employees`.`last_name`, `employees`.`middle_name`), " ", "") LIKE ?', $this->trimmed)
                ->orWhereRaw('REPLACE(CONCAT_WS("", `employees`.`last_name`, SUBSTRING_INDEX(`employees`.`first_name`, " ", 1), `employees`.`middle_name`), " ", "") LIKE ?', $this->trimmed)
                //for searching the location
                ->orWhereRaw('REPLACE(CONCAT_WS("", `employee_locations`.`city`, `employee_locations`.`country`), " ", "") LIKE ?', $this->trimmed)
                //for searching the skills
                ->orWhere('skills.name', 'LIKE', $this->trimmed)
                //for searching the employee number
                ->orWhere('employees.employee_no', 'LIKE', $this->trimmed)
                //for searching the client name
                ->orWhere('clients.company', 'LIKE', '%' . $this->term . '%')
                    ->when(strpos('unassigned',$this->term) !== false, function($q){
                        return $q->orWhere('clients.company', '=', NULL);
                    })
                //for searching the project name
                ->orWhere('client_projects.project_name', 'LIKE', '%' . $this->term . '%')
                    ->when(strpos('unassigned',$this->term) !== false, function($q){
                        return $q->orWhere('client_projects.project_name', '=', NULL);
                    })
                //for searching the job position
                ->orWhere('job_positions.job_title', 'LIKE', '%' . $this->term . '%')
                    ->when(strpos('unassigned',$this->term) !== false, function($q){
                        return $q->orWhere('job_positions.job_title', '=', NULL);
                    })
                ->orWhere('statuses.name', 'LIKE', '%'. $this->term . '%');
        });
    }
}
