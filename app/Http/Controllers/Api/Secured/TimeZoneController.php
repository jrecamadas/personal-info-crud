<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use Dingo\Api\Http\Request;
use App\Repositories\TimeZone\ZoneRepository;
use App\Validators\ZoneValidator;
use App\Transformers\ZoneTransformer;

class TimeZoneController extends BaseController
{
    public function __construct(ZoneRepository $repository, ZoneValidator $validator, ZoneTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
