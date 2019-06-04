<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Models\ActivityLog;
use App\Repositories\Client\ClientProjectRepository;
use App\Repositories\Client\ClientRepository;
use App\Services\ActivityLogService;
use App\Validators\ClientProjectValidator;
use App\Transformers\ClientProjectTransformer;
use Dingo\Api\Http\Request;
use App\Criterias\ClientProject\SearchByClient;
use App\Criterias\ClientProject\Search;

class ClientProjectController extends BaseController
{
    protected  $clientRepository;

    public function __construct(ClientProjectRepository $repository, ClientProjectValidator $validator, ClientProjectTransformer $transformer, ClientRepository $clientRepository)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
        $this->clientRepository = $clientRepository;
    }

    /**
     * Get list of client projects
     *
     * @return Collection
     */
    public function index(Request $request)
    {
        if ($request->get('client_id')) {
            $this->repository->pushCriteria(new SearchByClient($request->get('client_id')));
        } 
        if ($request->get('search')) {
            $this->repository->pushCriteria(new Search($request->get('search')));
        }

        return parent::index($request);
    }

    public function store(Request $request)
    {
        $response = parent::store($request);

        $client = $this->clientRepository->find($request->get('client_id'));
        if (!empty($client)) {
            // log response if success
            if ($response->status() === config('const.STATUS_CODE.SUCCESS')) {
                ActivityLogService::log([
                    'description' => 'Successfully added (' . $request->get('project_name') . ') a project in (' . $client->company . ') client.',
                    'model' => $this->repository->model()
                ]);
            } else if ($response->status() === config('const.STATUS_CODE.BAD_REQUEST')) {
                ActivityLogService::log([
                    'description' => 'Failed to add (' . $request->get('project_name') . ') a project in (' . $client->company . ') client.',
                    'log_type' => ActivityLog::LOG_TYPE_ERROR,
                    'model' => $this->repository->model()
                ]);
            }
        }
    }

    public function update(Request $request, $id)
    {
        $clientProject = $this->repository->find($id);
        $response = parent::update($request, $id);

        if(!empty($clientProject)) {
            if($response->status() === config('const.STATUS_CODE.SUCCESS')) {
                ActivityLogService::log([
                    'description' => 'Successfully updated (' . $clientProject->project_name . ') a project in (' . $clientProject->client->company . ') client.',
                    'model' => $this->repository->model()
                ]);
            } else if ($response->status() === config('const.STATUS_CODE.BAD_REQUEST')) {
                ActivityLogService::log([
                    'description' => 'Failed to update (' . $clientProject->project_name . ') a project in (' . $clientProject->client->company . ') client.',
                    'model' => $this->repository->model()
                ]);
            }
        }

        return $response;
    }

    public function destroy($id)
    {
        $clientProject = $this->repository->find($id);
        $response = parent::destroy($id);

        if (!empty($clientProject)) {
            if($response->status() === config('const.STATUS_CODE.NO_CONTENT')) {
                ActivityLogService::log([
                    'description' => 'Successfully deleted (' . $clientProject->project_name . ') as contact in (' . $clientProject->client->company . ') client.',
                    'model' => $this->repository->model()
                ]);
            } else if ($response->status() === config('const.STATUS_CODE.INTERNAL_SERVER_ERROR') || $response->status() === config('const.status_code.not_found')) {
                ActivityLogService::log([
                    'description' => 'Failed to delete (' . $clientProject->project_name . ') as contact in (' . $clientProject->client->company . ') client.',
                    'model' => $this->repository->model(),
                    'log_type' => ActivityLog::LOG_TYPE_ERROR
                ]);
            }
        }

        return $response;
    }
}
