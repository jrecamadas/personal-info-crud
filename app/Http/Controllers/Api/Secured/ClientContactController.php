<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Models\ActivityLog;
use App\Repositories\Client\ClientContactRepository;
use App\Repositories\Client\ClientRepository;
use App\Services\ActivityLogService;
use App\Validators\ClientContactValidator;
use App\Transformers\ClientContactTransformer;
use Dingo\Api\Http\Request;
use App\Criterias\ClientContact\SearchByClient;
use App\Criterias\Client\SearchByClientId;
use App\Criterias\Client\SeachByEmail;
use App\Criterias\ClientContact\SearchByEmails;
use App\Criterias\ClientContact\SearchByNotId;

class ClientContactController extends BaseController
{
    protected $clientRepository;

    public function __construct(ClientContactRepository $repository, ClientContactValidator $validator, ClientContactTransformer $transformer, ClientRepository $clientRepository)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
        $this->clientRepository = $clientRepository;
    }

    /**
     * Get list of client contacts
     *
     *
     * @param Dingo\Api\Http\Request $request
     * @return Collection
     */
    public function index(Request $request)
    {
        // filter by client
        if ($request->get('client')) {
            // add SearchByClient criteria
            $this->repository->pushCriteria(new SearchByClient($request->get('client')));
        } 

        if ($request->get('client_id')) {
            $this->repository->pushCriteria(new SearchByClientId($request->get('client_id')));
        }

        if ($request->get('current_id')) {
            $this->repository->pushCriteria(new SearchByNotId($request->get('current_id')));
        }

        if ($request->get('email')) {
            $this->repository->pushCriteria(new SeachByEmail($request->get('email')));
        }

        if ($request->get('emails')) {
            $emailsArr = explode('@@', $request->get('emails'));
            $this->repository->pushCriteria(new SearchByEmails($emailsArr));
        }
        
        // Call mom!
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
                    'description' => 'Successfully added (' . $request->get('email') . ') as contact in (' . $client->company . ') client.',
                    'model' => $this->repository->model()
                ]);
            } else if ($response->status() === config('const.STATUS_CODE.BAD_REQUEST')) {
                ActivityLogService::log([
                    'description' => 'Failed to add (' . $request->get('email') . ') as contact in (' . $client->company . ') client.',
                    'log_type' => ActivityLog::LOG_TYPE_ERROR,
                    'model' => $this->repository->model()
                ]);
            }
        }

        return $response;
    }

    public function destroy($id)
    {
        $clientContact = $this->repository->find($id);
        $response = parent::destroy($id);

        if (!empty($clientContact)) {
            if($response->status() === config('const.STATUS_CODE.NO_CONTENT')) {
                ActivityLogService::log([
                    'description' => 'Successfully deleted (' . $clientContact->email . ') as contact in (' . $clientContact->client->company . ') client.',
                    'model' => $this->repository->model()
                ]);
            } else if ($response->status() === config('const.STATUS_CODE.INTERNAL_SERVER_ERROR') || $response->status() === config('const.status_code.not_found')) {
                ActivityLogService::log([
                    'description' => 'Failed to delete (' . $clientContact->email . ') as contact in (' . $clientContact->client->company . ') client.',
                    'log_type' => ActivityLog::LOG_TYPE_ERROR,
                    'model' => $this->repository->model()
                ]);
            }
        }

        return $response;
    }

    public function update(Request $request, $id)
    {
        $clientContact = $this->repository->find($id);
        $response = parent::update($request, $id);

        if(!empty($clientContact)) {
            if($response->status() === config('const.STATUS_CODE.SUCCESS')) {
                ActivityLogService::log([
                    'description' => 'Successfully updated (' . $clientContact->email . ') a contact in (' . $clientContact->client->company . ') client.',
                    'model' => $this->repository->model()
                ]);
            } else if ($response->status() === config('const.STATUS_CODE.BAD_REQUEST')) {
                ActivityLogService::log([
                    'description' => 'Failed to update (' . $clientContact->email . ') a contact in (' . $clientContact->client->company . ') client.',
                    'model' => $this->repository->model()
                ]);
            }
        }

        return $response;
    }
}
