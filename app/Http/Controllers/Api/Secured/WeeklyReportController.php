<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\WeeklyReport\WeeklyReportRepository;
use App\Validators\WeeklyReportValidator;
use App\Transformers\WeeklyReportTransformer;
use Dingo\Api\Http\Request;
use App\Criterias\WeeklyReport\GetWeeklyReportByJobcode;
use App\Criterias\WeeklyReport\GetWeeklyReportByProjectIdAndYear;
use App\Criterias\Common\WithTrashed;

class WeeklyReportController extends BaseController
{
    public function __construct(WeeklyReportRepository $repository, WeeklyReportValidator $validator, WeeklyReportTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    public function index(Request $request)
    {
        if (!empty($request->get('jobcode'))) {
            $this->repository->pushCriteria(new GetWeeklyReportByJobcode($request->get('jobcode')));
            $otherDetails= false;
            if (!empty($request->get('year'))) {
                $param = [
                    'jobcode'       => $request->get('jobcode'),
                    'year'          => $request->get('year'),
                    'month'         => $request->get('month')
                ];
                $otherDetails = true;
                $this->repository->pushCriteria(new GetWeeklyReportByProjectIdAndYear($param));
            }
        }
        $this->transformer->setOtherDetails($otherDetails);

        return parent::index($request);
    }
}
