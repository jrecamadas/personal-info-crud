<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Models\ActivityLog;
use App\Services\ActivityLogService;
use App\Services\EmployeeService;
use Dingo\Api\Http\Request;
use App\Repositories\Client\EmployeeClientProjectRepository;
use App\Validators\EmployeeClientProjectValidator;
use App\Transformers\EmployeeClientProjectTransformer;
use App\Criterias\Project\SearchByProject;
use App\Criterias\Common\WithTrashed;
use App\Criterias\EmployeeClientProject\SearchIncludeSoftDeleted;
use App\Criterias\EmployeeClientProject\SearchByEmployee;
use App\Criterias\EmployeeClientProject\WithEmployee;

class EmployeeClientProjectController extends BaseController
{
    public function __construct(EmployeeClientProjectRepository $repository, EmployeeClientProjectValidator $validator, EmployeeClientProjectTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    /**
     *
     * @param Dingo\Api\Http\Request $request
     * @return Collection
     */
    public function index(Request $request)
    {
        if ($request->get('employee_id')) {
            $this->repository->pushCriteria(new SearchIncludeSoftDeleted($request->get('employee_id')));
        }

        if ($request->get('employee')) {
            $this->repository->pushCriteria(new SearchByEmployee($request->get('employee')));
        }

        if ($request->get('project_id')) {
            $this->repository->pushCriteria(new SearchByProject($request->get('project_id')));
            $this->repository->pushCriteria(new WithEmployee());
        }

        // Call mom!
        return parent::index($request);
    }

    /**
     * Restore back employee to the Client Project
     *
     * @param Dingo\Api\Http\Request $request
     * @return Item
     */
    public function update(Request $request, $id) {
        // since employee has been pull out from the Client project
        // we need this criteria
        $this->repository->pushCriteria(new WithTrashed());

        // we need to restore (set deleted_at to NULL) prior to updating
        $this->repository->find($id)->restore();

        // Call mom!
        return parent::update($request, $id);
    }

    public function store(Request $request)
    {
        $response = parent::store($request);

        $content = json_decode($response->content(), true);
        $employeeClientProject = $this->repository->find($content['id']);
        // log response if success
        if ($response->status() === config('const.STATUS_CODE.SUCCESS')) {
            ActivityLogService::log([
                'description' => 'Successfully added (' . EmployeeService::getEmployeeName($employeeClientProject->employee) . ') new resource in (' . $employeeClientProject->clientProject->project_name . ') client.',
                'model' => $this->repository->model()
            ]);
        } else if ($response->status() === config('const.STATUS_CODE.BAD_REQUEST')) {
            ActivityLogService::log([
                'description' => 'Failed to add (' . EmployeeService::getEmployeeName($employeeClientProject->employee) . ') a project in (' . $employeeClientProject->clientProject->project_name . ') client.',
                'log_type' => ActivityLog::LOG_TYPE_ERROR,
                'model' => $this->repository->model()
            ]);
        }

        return $response;
    }

    public function destroy($id)
    {
        $employeeClientProject = $this->repository->find($id);
        $response = parent::destroy($id);

        if (!empty($employeeClientProject)) {
            if ($response->status() === config('const.STATUS_CODE.NO_CONTENT')) {
                ActivityLogService::log([
                    'description' => 'Successfully removed (' . EmployeeService::getEmployeeName($employeeClientProject->employee) . ') as resource in (' . $employeeClientProject->clientProject->project_name . ') client.',
                    'model' => $this->repository->model()
                ]);
            } else if ($response->status() === config('const.STATUS_CODE.INTERNAL_SERVER_ERROR') || $response->status() === config('const.status_code.not_found')) {
                ActivityLogService::log([
                    'description' => 'Failed to remove (' . EmployeeService::getEmployeeName($employeeClientProject->employee) . ') as resource in (' . $employeeClientProject->clientProject->project_name . ') client.',
                    'log_type' => ActivityLog::LOG_TYPE_ERROR,
                    'model' => $this->repository->model()
                ]);
            }
        }

        return $response;
    }
}
