<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Employee\EmployeeRepository;
use App\Validators\EmployeeValidator;
use App\Transformers\EmployeeTransformer;
use App\Models\Leave\LeaveType;
use App\Criterias\Employee\UserNameOrUniqueStrEqualTo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use SnappyPDF;

class EmployeeLeaveReportController extends BaseController
{
    public function __construct(EmployeeRepository $repository, EmployeeValidator $validator, EmployeeTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    public function reportPDF($username)
    {
        try {
            $employee               = $this->getUserByUsername($username);
            $leaveTypes             = LeaveType::pluck('name')->toArray();
            $department             = $employee->department;
            $status                 = $employee->employeeStatuses->last();
            $positions              = $employee->positions;
            $photo                  = $employee->photo->where('type', 1)->last();
            $projects               = $employee->projects;
            $clientProject          = $employee->clientProject;
            $leaveRequests          = $employee->leaveRequests;
            $name                   = "{$employee->first_name}_{$employee->last_name}" . time() . ".pdf";
            $pdf                    = SnappyPDF::loadView(
                'leave.report',
                compact(
                    'employee',
                    'department',
                    'status',
                    'positions',
                    'photo',
                    'projects',
                    'clientProject',
                    'leaveTypes',
                    'leaveRequests',
                    'name'
                )
            );

            return $pdf->stream($name);
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'status_code' => 404,
                    'message' => 'Can\'t find the requested resource.'
                ], 404
            );
        }
    }

    private function getUserByUsername($username)
    {
        $this->repository->pushCriteria(new UserNameOrUniqueStrEqualTo($username));
        return $this->repository->first();
    }
}
