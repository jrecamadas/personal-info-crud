<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Language\LanguageRepository;
use App\Validators\LanguageValidator;
use App\Transformers\LanguageTransformer;
use Dingo\Api\Http\Request;

class LanguageController extends BaseController
{
    public function __construct(LanguageRepository $repository, LanguageValidator $validator, LanguageTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
