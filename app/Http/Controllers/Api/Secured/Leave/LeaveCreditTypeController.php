<?php

namespace App\Http\Controllers\Api\Secured\Leave;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Leave\LeaveCreditTypeRepository;
use App\Transformers\Leave\LeaveCreditTypeTransformer;
use App\Validators\Leave\LeaveCreditTypeValidator;
use App\Criterias\LeaveCreditType\SearchLeaveCreditTypeByName;
use Dingo\Api\Http\Request;

class LeaveCreditTypeController extends BaseController
{
    public function __construct(LeaveCreditTypeRepository $repository, LeaveCreditTypeValidator $validator, LeaveCreditTypeTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    public function index(Request $request)
    {
        if ($request->get('search')) {
            $this->repository->pushCriteria(new SearchLeaveCreditTypeByName($request->get('search')));
        }

        return parent::index($request);
    }
}
