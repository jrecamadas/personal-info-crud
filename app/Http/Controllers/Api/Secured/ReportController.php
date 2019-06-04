<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Report\ReportRepository;
use App\Validators\ReportValidator;
use App\Transformers\ReportTransformer;

class ReportController extends BaseController
{
    public function __construct(ReportRepository $repository, ReportValidator $validator, ReportTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
