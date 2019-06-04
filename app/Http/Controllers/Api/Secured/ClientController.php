<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Models\ActivityLog;
use App\Repositories\Client\ClientRepository;
use App\Services\ActivityLogService;
use App\Validators\ClientValidator;
use App\Transformers\ClientTransformer;
use Dingo\Api\Http\Request;
use App\Criterias\Client\SearchByCompanyName;
use App\Criterias\Client\WithProjectCount;
use App\Criterias\Client\WithResourceCount;
use App\Criterias\Client\SearchByCompanyNameExact;
use App\Criterias\Client\SearchByStatus;
use App\Criterias\Client\SortByCreatedatAndStatus;


class ClientController extends BaseController
{
    public function __construct(ClientRepository $repository, ClientValidator $validator, ClientTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    /**
     * Get list of clients
     *
     * @return Collection
     */
    public function index(Request $request)
    {
        // see if we have searches
        if ($request->get('search')) {
            // add SearchByCompanyName criteria
            $this->repository->pushCriteria(new SearchByCompanyName($request->get('search')));
        }

        if ($request->get('company')) {
            // add SearchByCompanyName criteria
            $this->repository->pushCriteria(new SearchByCompanyNameExact($request->get('company')));
        }
        
        if ($request->get('status')) {
            // add SearchByStatus criteria
            if ($request->get('status') == 'active') {
                $status = 0;
            }
            $this->repository->pushCriteria(new SearchByStatus($status));
        }

        // default criteria
        $this->repository->pushCriteria(new WithProjectCount());
        $this->repository->pushCriteria(new WithResourceCount());
        $this->repository->pushCriteria(new SortByCreatedatAndStatus());

        $response = parent::index($request);

        // log response if success
        if (
            $response->status() === config('const.STATUS_CODE.SUCCESS') &&
            !empty($request->get('take'))
        ) {
            ActivityLogService::log([
                'description' => 'viewed all clients.',
                'model' => $this->repository->model()
            ]);
        }

        return $response;
    }

    public function show($id)
    {
        // default criteria
        $this->repository->pushCriteria(new WithProjectCount());
        $this->repository->pushCriteria(new WithResourceCount());

        $response = parent::show($id);

        // log response if success
        if ($response->status() === config('const.STATUS_CODE.SUCCESS')) {
            ActivityLogService::log([
                'description' => 'viewed (' . $response->getOriginalContent()->company . ') client.',
                'model' => $this->repository->model()
            ]);
        }

        return $response;
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
        $request = new Request($request->except(['contacts', 'projects_count', 'resources_count', 'photo', 'projects', 'key', 'name']));
        $response =  parent::store($request);

        // log response if success
        if ($response->status() === config('const.STATUS_CODE.SUCCESS')) {
            ActivityLogService::log([
                'description' => 'successfully added (' . $request->get('company') . ') client.',
                'model' => $this->repository->model()
            ]);
        } else if ($response->status() === config('const.STATUS_CODE.BAD_REQUEST')) {
            ActivityLogService::log([
                'description' => 'failed to add (' . $request->get('company') . ') client.',
                'log_type' => ActivityLog::LOG_TYPE_ERROR,
                'model' => $this->repository->model()
            ]);
        }

        return $response;
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
        $request = new Request($request->except(['contacts', 'projects_count', 'resources_count', 'photo', 'projects', 'key', 'name']));
        $response = parent::update($request, $id);

        // log response if success
        if ($response->status() === config('const.STATUS_CODE.SUCCESS')) {
            ActivityLogService::log([
                'description' => 'successfully updated (' . $request->get('company') . ') client.',
                'model' => $this->repository->model()
            ]);
        } else if ($response->status() === config('const.STATUS_CODE.BAD_REQUEST')) {
            ActivityLogService::log([
                'description' => 'failed to update (' . $request->get('company') . ') client.',
                'log_type' => ActivityLog::LOG_TYPE_ERROR,
                'model' => $this->repository->model()
            ]);
        }

        return $response;
    }
}
