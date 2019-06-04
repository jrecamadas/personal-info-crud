<?php

namespace App\Http\Controllers\Api\Secured\Leave;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Leave\EmployeeLeaveCreditHistoryRepository;
use App\Transformers\Leave\EmployeeLeaveCreditHistoryTransformer;
use App\Validators\Leave\EmployeeLeaveCreditHistoryValidator;

class EmployeeLeaveCreditHistoryController extends BaseController
{
    public function __construct(EmployeeLeaveCreditHistoryRepository $repository, EmployeeLeaveCreditHistoryValidator $validator, EmployeeLeaveCreditHistoryTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
