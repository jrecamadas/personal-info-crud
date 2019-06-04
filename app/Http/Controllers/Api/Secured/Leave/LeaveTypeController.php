<?php

namespace App\Http\Controllers\Api\Secured\Leave;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Leave\LeaveTypeRepository;
use App\Transformers\Leave\LeaveTypeTransformer;
use App\Validators\Leave\LeaveTypeValidator;
use App\Criterias\LeaveType\SearchLeaveTypeByName;
use Dingo\Api\Http\Request;

class LeaveTypeController extends BaseController
{
    public function __construct(LeaveTypeRepository $repository, LeaveTypeValidator $validator, LeaveTypeTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    public function index(Request $request)
    {
        if ($request->get('search')) {
            $this->repository->pushCriteria(new SearchLeaveTypeByName($request->get('search')));
        }

        return parent::index($request);
    }
}
