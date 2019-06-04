<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\AllQuestion\QuestionResponseRepository;
use App\Transformers\AllQuestion\ResponseTransformer as QuestionResponseTransformer;
use App\Validators\AllQuestion\QuestionResponseValidator;
use Dingo\Api\Http\Request;
use App\Criterias\AllQuestion\FilterByCategory;
use App\Criterias\AllQuestion\FilterByClient;

class AllQuestionResponseController extends BaseController
{
    public function __construct(QuestionResponseRepository $repository, QuestionResponseValidator $validator, QuestionResponseTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    public function index(Request $request)
    {
        if ($request->get('filterBy')) {
            $filterBy = explode(',', $request->get('filterBy'));
            $filter   = explode(',', $request->get('filterVar'));

            foreach ($filterBy as $key => $value) {
                switch (strtolower(trim($value))) {
                    case 'category':
                        $this->repository->pushCriteria(new FilterByCategory($filter[$key]));// id or name
                        break;
                    case 'client':
                        $this->repository->pushCriteria(new FilterByClient($filter[$key]));
                        break;
                }
            }
        }

        return parent::index($request);
    }

    /**
     * Handle POST request for the resource, saving new data
     *
     * @param Dingo\Api\Http\Request $request
     * @return Resource Item
     */
    public function store(Request $request)
    {
        $modelObj = app($this->repository->model());
        $this->authorize('create', $modelObj);

        try {
            $this->validator->with($request->all())->passesOrFail('create');

            $result = $this->repository->saveAllResponses($request->all());

            return $this->response->collection(collect($result), $this->transformer);
        } catch (ValidatorException $e) {
            return response()->json([
                'status_code' => 400,
                'message' => $e->getMessageBag(),
            ], 400);
        }
    }
}
