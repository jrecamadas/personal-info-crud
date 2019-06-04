<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Employee\EmployeeLocationRepository;
use App\Validators\EmployeeLocationValidator;
use App\Transformers\EmployeeLocationTransformer;
use App\Criterias\EmployeeLocation\SearchByEmployeeID;
use Dingo\Api\Http\Request;

class EmployeeLocationController extends BaseController
{
    public function __construct(EmployeeLocationRepository $repository, EmployeeLocationValidator $validator, EmployeeLocationTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    /**
     * Get employee location
     *
     * @return Collection
     */
    public function index(Request $request)
    {
        if ($request->get('employee_id')) {
            $this->repository->pushCriteria(new SearchByEmployeeID($request->get('employee_id')));
        }
        
        return parent::index($request);
    }
}
