<?php
namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Employee\EmployeePortfolioRepository;
use App\Validators\EmployeePortfolioValidator;
use App\Transformers\EmployeePortfolioTransformer;

class EmployeePortfolioController extends BaseController
{
    public function __construct(EmployeePortfolioRepository $repository, EmployeePortfolioValidator $validator, EmployeePortfolioTransformer $transformer)
    {
        $this->repository = $repository;
        $this->transformer = $transformer;
        $this->validator = $validator;
    }
}
