<?php

namespace App\Http\Controllers\Api\Secured;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\ReferralType\ReferralTypeRepository;
use App\Validators\ReferralTypeValidator;
use App\Transformers\ReferralTypeTransformer;

class ReferralTypeController extends BaseController
{

    public function __construct(ReferralTypeRepository $repository, ReferralTypeValidator $validator, ReferralTypeTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
