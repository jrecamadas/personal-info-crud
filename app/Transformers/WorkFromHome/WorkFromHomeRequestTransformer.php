<?php

namespace App\Transformers\WorkFromHome;

use App\Models\WorkFromHome\WorkFromHomeRequest;
use App\Services\EmployeeService;
use App\Transformers\EmployeeTransformer;
use League\Fractal\TransformerAbstract;

class WorkFromHomeRequestTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'employee'
    ];

    public function transform(WorkFromHomeRequest $workFromHomeRequest)
    {
        return [
            'id'            => (int)$workFromHomeRequest->id,
            'employee_name' => EmployeeService::getEmployeeName($workFromHomeRequest->employee, true),
            'projects'      => EmployeeService::getEmployeeProjects($workFromHomeRequest->employee),
            'positions'     => EmployeeService::getEmployeePositions($workFromHomeRequest->employee),
            'start_date'    => $workFromHomeRequest->start_date,
            'end_date'      => $workFromHomeRequest->end_date,
            'reason'        => $workFromHomeRequest->reason,
            'notified_at'   => $workFromHomeRequest->notified_at
        ];
    }

    /**
     * Include Employee
     *
     * @param  WorkFromHomeRequest $workFromHomeRequest
     * @return Collection
     */
    public function includeEmployee(WorkFromHomeRequest $workFromHomeRequest)
    {
        return $this->item($workFromHomeRequest->employee, new EmployeeTransformer());
    }
}
