<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Status\StatusRepository;
use App\Validators\StatusValidator;
use App\Transformers\StatusTransformer;
use App\Criterias\Employee\SearchByEmployeeStatus;
use App\Criterias\Status\FilterByUserStanding;
use Dingo\Api\Http\Request;

class StatusController extends BaseController
{
    const APP_STATUSES = 1;
    const EMP_STATUSES = 2;
    const TRIGGER_STATUS = 3;

    public function __construct(StatusRepository $repository, StatusValidator $validator, StatusTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    public function index(Request $request)
    {
        if ($request->get('search')) {
            $this->repository->pushCriteria(new SearchByEmployeeStatus($request->get('search')));
        }

        if (strcasecmp('applicant', $request->get('for')) == 0) {
            $this->repository->pushCriteria(new FilterByUserStanding([$this::APP_STATUSES, $this::TRIGGER_STATUS]));
        }

        /** Hired should also be shown in Employee. That's the common stat between applicant/employee */
        if (strcasecmp('employee', $request->get('for')) == 0) {
            $this->repository->pushCriteria(new FilterByUserStanding([$this::EMP_STATUSES, $this::TRIGGER_STATUS]));
        }

        if (strcasecmp('employee-status-filter', $request->get('for')) == 0) {
            $this->repository->pushCriteria(new FilterByUserStanding([$this::EMP_STATUSES, $this::TRIGGER_STATUS]));
        }

        return parent::index($request);
    }
}
