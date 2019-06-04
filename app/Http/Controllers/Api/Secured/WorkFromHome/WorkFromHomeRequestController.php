<?php

namespace App\Http\Controllers\Api\Secured\WorkFromHome;

use App\Criterias\WorkFromHome\FilterByEmployeeId;
use App\Criterias\WorkFromHome\SelectWorkFromHomeRequest;
use App\Criterias\WorkFromHome\WithEmployee;
use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\WorkFromHome\WorkFromHomeRequestRepository;
use App\Transformers\WorkFromHome\WorkFromHomeRequestTransformer;
use App\Validators\WorkFromHome\WorkFromHomeRequestValidator;
use Dingo\Api\Http\Request;
use App\Criterias\Employee\SearchByNameOrFullName;

class WorkFromHomeRequestController extends BaseController
{
    public function __construct(
        WorkFromHomeRequestRepository $repository,
        WorkFromHomeRequestValidator $validator,
        WorkFromHomeRequestTransformer $transformer
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    public function index(Request $request)
    {
        // prevents overriding the `id` when joining
        $this->repository->pushCriteria(new SelectWorkFromHomeRequest());

        $this->repository->pushCriteria(new WithEmployee());

        if ($request->get('search')) {
            $this->repository->pushCriteria(new SearchByNameOrFullName($request->get('search')));
        }

        if ($request->get('employee_id')) {
            $this->repository->pushCriteria(new FilterByEmployeeId($request->get('employee_id')));
        }

        return parent::index($request);
    }
}
