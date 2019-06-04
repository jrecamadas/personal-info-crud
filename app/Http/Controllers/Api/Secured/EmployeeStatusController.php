<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Employee\EmployeeStatusRepository;
use App\Repositories\User\UserRepository;
use App\Validators\EmployeeStatusValidator;
use Dingo\Api\Http\Request;
use App\Models\Employee;
use App\Transformers\EmployeeStatusTransformer;

class EmployeeStatusController extends BaseController
{
    public function __construct(EmployeeStatusRepository $repository, EmployeeStatusValidator $validator, EmployeeStatusTransformer $transformer, UserRepository $userRepo)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
        $this->userRepo = $userRepo;
    }

    public function store(Request $request)
    {
        $employee_status = [20, 21, 22];

        if (in_array(intval($request->get('status_id')), $employee_status)) {

            $employee = Employee::where('id', $request->get('employee_id'))->first();

            $this->userRepo->update(
                ['can_login' => 0],
                $employee->user_id
            );
        }

        return parent::store($request);
    }
}
