<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use Dingo\Api\Http\Request;
use App\Repositories\ReportTemplate\ReportTemplateRepository;
use App\Validators\ReportTemplateValidator;
use App\Transformers\ReportTemplateTransformer;
use App\Criterias\ReportTemplate\WithReport;
use App\Criterias\ReportTemplate\SearchByReportType;
use App\Criterias\ReportTemplate\SearchByReportTypeId;
use App\Criterias\ReportTemplate\DefaultReportTemplate;
use App\Criterias\ReportTemplate\Select;

class ReportTemplateController extends BaseController
{
    public function __construct(ReportTemplateRepository $repository, ReportTemplateValidator $validator, ReportTemplateTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    public function index(Request $request)
    {
    	$this->repository->pushCriteria(new WithReport());
        
        // search by report type
        if ($request->get('type'))
            $this->repository->pushCriteria(new SearchByReportType($request));

        // search by report type id
        if ($request->get('report_id'))
            $this->repository->pushCriteria(new SearchByReportTypeId($request));

        
        if ($request->get('default'))
            $this->repository->pushCriteria(new DefaultReportTemplate($request));
        
        $this->repository->pushCriteria(new Select());
    	return parent::index($request);
    } 
}
