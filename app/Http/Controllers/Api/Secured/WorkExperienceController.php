<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\WorkExperience\WorkExperienceRepository;
use App\Validators\WorkExperienceValidator;
use App\Transformers\WorkExperienceTransformer;
use app\Models\WorkExperience as WorkExperience;
use Dingo\Api\Http\Request;
use App\Criterias\WorkExperience\SearchDuplicate;
use Validator;

class WorkExperienceController extends BaseController
{
    public function __construct(WorkExperienceRepository $repository, WorkExperienceValidator $validator, WorkExperienceTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
