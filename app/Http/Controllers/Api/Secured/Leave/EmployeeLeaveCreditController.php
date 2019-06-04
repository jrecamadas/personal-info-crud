<?php

namespace App\Http\Controllers\Api\Secured\Leave;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Leave\EmployeeLeaveCreditRepository;
use App\Transformers\Leave\EmployeeLeaveCreditTransformer;
use App\Validators\Leave\EmployeeLeaveCreditValidator;
use Dingo\Api\Http\Request;

class EmployeeLeaveCreditController extends BaseController
{
    public function __construct(EmployeeLeaveCreditRepository $repository, EmployeeLeaveCreditValidator $validator, EmployeeLeaveCreditTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    /**
     * POST save a resource
     *
     * @param Dingo\Api\Http\Request $request
     * @return Resource Item
     */
    public function store(Request $request)
    {
    	// we remove these request data, we don't store these in db
        $request = new Request($request->except(['days', 'action']));
    	return parent::store($request);
    }    

    /**
     * PUT|PATCH update a resource
     *
     * @param Dingo\Api\Http\Request $request
     * @param int $id
     * @return Resource Item
     */
    public function update(Request $request, $id)
    {
        // we remove these request data, we don't store these in db
        $request = new Request($request->except(['days', 'action']));
    	return parent::update($request, $id);
    }
}
