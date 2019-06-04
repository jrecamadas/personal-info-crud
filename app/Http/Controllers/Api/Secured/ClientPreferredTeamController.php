<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\ClientPreferredTeam\ClientPreferredTeamRepository;
use App\Validators\ClientPreferredTeamValidator;
use App\Transformers\ClientPreferredTeamTransformer;
use Dingo\Api\Http\Request;
use App\Criterias\ClientPreferredTeam\SearchByClientID;
use App\Criterias\Common\WithTrashed;

class ClientPreferredTeamController extends BaseController
{
    public function __construct(ClientPreferredTeamRepository $repository, ClientPreferredTeamValidator $validator, ClientPreferredTeamTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

     /**
     * Get list of client preferred teams
     *
     * @return Collection
     */
    public function index(Request $request)
    {
        if ($request->get('client_id')) {
            $this->repository->pushCriteria(new SearchByClientID($request->get('client_id')));
        }

        return parent::index($request);
    }


    /**
     * Restore back employee to the Client preferred
     *
     * @param Dingo\Api\Http\Request $request
     * @return Item
     */
    public function update(Request $request, $id) {
        // since employee has been pull out from the Client preferred
        // we need this criteria
        $this->repository->pushCriteria(new WithTrashed());

        // we need to restore (set deleted_at to NULL) prior to updating
        $this->repository->find($id)->restore();

        // Call mom!
        return parent::update($request, $id);
    }
}
