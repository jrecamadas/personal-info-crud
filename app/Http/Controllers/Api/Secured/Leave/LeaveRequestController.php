<?php

namespace App\Http\Controllers\Api\Secured\Leave;

use App\Criterias\LeaveRequest\AddSelect;
use App\Criterias\LeaveRequest\FilterByLeaveTypeId;
use App\Criterias\LeaveRequest\FilterByStartDateAndEndDate;
use App\Criterias\LeaveRequest\FilterByStatus;
use App\Criterias\LeaveRequest\GroupByBatchFilterByStartDateAndEndDate;
use App\Criterias\LeaveRequest\GroupByBatchFilterByStatus;
use App\Criterias\LeaveRequest\SearchByName;
use App\Criterias\LeaveRequest\WithEmployee;
use App\Criterias\LeaveRequest\WithEmployeeApprover;
use App\Criterias\LeaveRequest\WithLeaveType;
use App\Criterias\LeaveRequest\WithoutCurrentUser;
use App\Models\Employee;
use App\Criterias\LeaveRequest\ValidApprover;
use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Leave\LeaveRequestRepository;
use App\Transformers\Leave\LeaveRequestTransformer;
use App\Validators\Leave\LeaveRequestValidator;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Criterias\LeaveRequest\FilterByEmployeeId;
use App\Criterias\LeaveRequest\GroupByBatchFilterLeaveRequest;

class LeaveRequestController extends BaseController
{
    public function __construct(LeaveRequestRepository $repository, LeaveRequestValidator $validator, LeaveRequestTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    public function index(Request $request)
    {
        $this->repository->pushCriteria(new AddSelect());
        $this->repository->pushCriteria(new WithEmployee());

        $this->repository->pushCriteria(new WithLeaveType());    

        if ($request->get('search')) {
            switch ($request->get('searchBy')) {
                case "employee.name":
                    $this->repository->pushCriteria(new SearchByName($request->get('search')));
            }
        }

        if ($request->get('employee_id')) {
           $this->repository->pushCriteria(new FilterByEmployeeId($request->get('employee_id')));
        } else {
            $this->repository->pushCriteria(new WithEmployeeApprover());
            $authUser = request()->user();
            $employee = Employee::where('user_id', $authUser->id)->first();
            
            if($employee) {
                $this->repository->pushCriteria(new ValidApprover($employee->id));
                $this->repository->pushCriteria(new WithoutCurrentUser($employee->id));
            }
        }

        if ($request->get('filters')) {
            $filter = explode('|', $request->get('filters'));
            switch ($filter[0]) {
                case 'status':
                    if ($request->get('batch')) {
                        $this->repository->pushCriteria(new GroupByBatchFilterByStatus($filter[1]));
                    } else {
                        $this->repository->pushCriteria(new FilterByStatus($filter[1]));
                    }
                    break;
                case 'leaveTypeId':
                    $this->repository->pushCriteria(new FilterByLeaveTypeId($filter[1]));
                    break;
                case 'dates':
                    if ($request->get('batch')) {
                        $this->repository->pushCriteria(new GroupByBatchFilterByStartDateAndEndDate($filter[1], $filter[2]));
                    } else {
                        $this->repository->pushCriteria(new FilterByStartDateAndEndDate($filter[1], $filter[2]));
                    }
                    break;
                case 'dates2':
                    if ($request->get('batch')) {
                        $this->repository->pushCriteria(new GroupByBatchFilterLeaveRequest($filter[1], $filter[2]));
                    } else {
                        $this->repository->pushCriteria(new FilterByStartDateAndEndDate($filter[1], $filter[2]));
                    }
                    break;
            }
        }

        if ($request->get('status')) {
            if ($request->get('batch')) {
                $this->repository->pushCriteria(new GroupByBatchFilterByStatus($request->get('status')));
            } else {
                $this->repository->pushCriteria(new FilterByStatus($request->get('status')));
            }
        }

        return parent::index($request);
    }

    /**
     * POST save a resource
     *
     * @param Dingo\Api\Http\Request $request
     * @return Resource Item
     */
    public function store(Request $request)
    {
        // we remove these request data, we don't store these in db
        $request = new Request($request->except(['prev_status','prev_approver_id']));

        return parent::store($request);
    }    

    /**
     * PUT|PATCH update a resource
     *
     * @param Dingo\Api\Http\Request $request
     * @param int $id
     * @return Resource Item
     */
    public function update(Request $request, $id)
    {
        // we remove these request data, we don't store these in db
        $request = new Request($request->except(['prev_status','prev_approver_id']));
        
        return parent::update($request, $id);
    }

}
