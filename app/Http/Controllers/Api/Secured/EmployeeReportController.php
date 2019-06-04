<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Employee\EmployeeReportRepository;
use App\Validators\EmployeeReportValidator;
use App\Transformers\EmployeeReportTransformer;
use App\Criterias\EmployeeReport\SearchByEmployee;
use App\Criterias\EmployeeReport\WithProject;
use App\Criterias\EmployeeReport\FilterByProject;
use App\Criterias\EmployeeReport\FilterByDate;
use App\Models\Employee;
use App\Models\ReportTemplate;
use App\Mail\DailyReport;
use Dingo\Api\Http\Request;

class EmployeeReportController extends BaseController
{
    public function __construct(EmployeeReportRepository $repository, EmployeeReportValidator $validator, EmployeeReportTransformer $transformer)
    {
        $this->repository = $repository;
        $this->transformer = $transformer;
        $this->validator = $validator;
    }
    /**
     * Get list of employee reports
     *
     * @return Collection
     */
    public function index(Request $request)
    {
        if ($request->get('employee_id')) {
            $this->repository->pushCriteria(new SearchByEmployee($request->get('employee_id')));
        }
        
        if ($request->get('filters')) {
            $filter = explode('|', $request->get('filters'));

            if ($filter[0] == 'project') {
                $this->repository->pushCriteria(new FilterByProject($filter[1]));
            } else {
                $date = explode(':', $filter[1]);

                $this->repository->pushCriteria(new FilterByDate($date[0], $date[1]));
            }
        }

        // default criteria
         $this->repository->pushCriteria(new WithProject());

        return parent::index($request);
    }

    public function preview(Request $request)
    {
        try {
            $report = new DailyReport($request);
            $employee = Employee::where('id', $request->employee_id)->first();
            $template = ReportTemplate::where('id', $request->report_template_id)->first();
            $report->setEmployeeAndTemplate($employee, $template);
            // $result = $this->repository->findWhere(['employee_id'=>$request->employee_id,'client_project_id'=>$request->client_project_id])->take(1);
            return ['preview' => $report->render()];
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status_code' => 404,
                'message' => 'Can\'t find the requested resource.'
            ], 404);
        }
    }
}

