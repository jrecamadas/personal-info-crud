<?php

namespace App\Http\Controllers\Api\Secured;

use Dingo\Api\Http\Request;
use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\PreEmploymentChecklist\PreEmploymentChecklistRepository;
use App\Validators\PreEmploymentChecklistValidator;
use App\Transformers\PreEmploymentChecklistTransformer;
use App\Models\PreEmploymentChecklist;

class PreEmploymentChecklistController extends BaseController
{
    public function __construct(PreEmploymentChecklistRepository $repository, PreEmploymentChecklistValidator $validator, PreEmploymentChecklistTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    /**
     * Get list of Pre Employment Checklist
     *
     * @return Collection
     */
    public function index(Request $request)
    {
        return parent::index($request);
    }
}