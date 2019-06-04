<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\JobPosition\JobPositionRepository;
use App\Validators\JobPositionValidator;
use App\Transformers\JobPositionTransformer;
use App\Criterias\JobPosition\SearchJob;
use Dingo\Api\Http\Request;

class JobPositionController extends BaseController
{
    public function __construct(JobPositionRepository $repository, JobPositionValidator $validator, JobPositionTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    /**
     * Get list of Job Positions
     *
     * @return Collection
     */
    public function index(Request $request)
    {
        // see if we have searches
        if ($request->get('search')) {
            // add SearchByJobTitle criteria
            $this->repository->pushCriteria(new SearchJob($request->get('search')));
        }

        return parent::index($request);
    }
}
