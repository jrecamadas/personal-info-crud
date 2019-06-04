<?php

namespace App\Http\Controllers\Api\Secured\Leave;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Leave\EmployeeApproverRepository;
use App\Transformers\Leave\EmployeeApproverTransformer;
use App\Validators\Leave\EmployeeApproverValidator;
use App\Criterias\EmployeeApprover\WithEmployee;
use App\Criterias\EmployeeApprover\WithDepartment;
use App\Criterias\Employee\SearchByNameOrFullName;
use App\Criterias\EmployeeApprover\AddSelect;
use App\Criterias\EmployeeApprover\FilterByLeaveApproverID;
use Dingo\Api\Http\Request;

class EmployeeApproverController extends BaseController
{
    public function __construct(EmployeeApproverRepository $repository, EmployeeApproverValidator $validator, EmployeeApproverTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    /**
     * Get list of employees
     *
     * @return Collection
     */
    public function index(Request $request)
    {
    	$this->repository->pushCriteria(new AddSelect());
    	$this->repository->pushCriteria(new WithEmployee());
    	$this->repository->pushCriteria(new WithDepartment());
        if ($request->get('search')) {
    		if ($request->get('searchBy') == 'name') {
                $this->repository->pushCriteria(new SearchByNameOrFullName($request->get('search')));
            }
        }
        if ($request->get('leave_approver_id')) {
            $this->repository->pushCriteria(new FilterByLeaveApproverID($request->get('leave_approver_id')));
        }
        return parent::index($request);
    }
}
