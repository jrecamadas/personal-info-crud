<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\EmployeeClientProject;

class EmployeeClientProjectTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'clientProject',
        'employee'
    ];

    public function transform(EmployeeClientProject $ecp)
    {
        return [
            'id'                => (int)$ecp->id,
            'employee_id'       => (int)$ecp->employee_id,
            'client_project_id' => (int)$ecp->client_project_id,
            'project_name'      => $ecp->clientProject->project_name,
            'client_name'       => $ecp->clientProject->client->company,
            'role'              => $ecp->role,
            'start_date'        => $ecp->start_date,
            'end_date'          => $ecp->end_date,
            'deleted_at'        => $ecp->deleted_at
        ];
    }

    public function includeClientProject(EmployeeClientProject $ecp)
    {
        if (is_null($ecp->clientProject)) {
            return null;
        }
        return $this->item($ecp->clientProject, new ClientProjectTransformer());
    }

    /**
     * Include Employee
     */
    public function includeEmployee(EmployeeClientProject $ecp)
    {
        $employee = $ecp->employee;

        if (is_null($employee)) {
            return null;
        }

        return $this->item($employee, new EmployeeTransformer());
    }
}
