<?php

namespace App\Http\Controllers\Api\Secured\Leave;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Leave\LeaveApproverRepository;
use App\Transformers\Leave\LeaveApproverTransformer;
use App\Validators\Leave\LeaveApproverValidator;
use App\Criterias\LeaveApprover\WithApprover;
use App\Criterias\LeaveApprover\WithOIC;
use App\Criterias\LeaveApprover\AddSelect;
use App\Criterias\LeaveApprover\SearchByName;
use Dingo\Api\Http\Request;

class LeaveApproverController extends BaseController
{
    public function __construct(LeaveApproverRepository $repository, LeaveApproverValidator $validator, LeaveApproverTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    /**
     * Get list of employees
     *
     * @return Collection
     */
    public function index(Request $request)
    {
    	$this->repository->pushCriteria(new AddSelect());
        $this->repository->pushCriteria(new WithApprover());
        $this->repository->pushCriteria(new WithOIC());
        if ($request->get('search')) {
    		if ($request->get('searchBy') == 'name') {
				$this->repository->pushCriteria(new SearchByName($request->get('search')));
            }
        }	
        return parent::index($request);
    }
}
