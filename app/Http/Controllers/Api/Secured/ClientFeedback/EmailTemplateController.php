<?php

namespace App\Http\Controllers\Api\Secured\ClientFeedback;

use App\Repositories\ClientFeedback\EmailTemplateRepository;
use App\Validators\ClientFeedback\EmailTemplateValidator;
use App\Transformers\ClientFeedback\EmailTemplateTransformer;
use App\Criterias\ClientFeedback\SearchByTemplateName;
use App\Criterias\ClientFeedback\SearchByTemplateNameExact;
use App\Criterias\ClientFeedback\SearchByStatus;
use Dingo\Api\Http\Request;
use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Traits\CleanPostData;

class EmailTemplateController extends BaseController
{
    use CleanPostData;

    public function __construct(
        EmailTemplateRepository $repository,
        EmailTemplateValidator $validator,
        EmailTemplateTransformer $transformer
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    public function index(Request $request)
    {
        if ($request->get('templateName')) {
            $this->repository->pushCriteria(new SearchByTemplateNameExact($request->get('templateName')));
        }

        if ($request->get('search')) {
            $this->repository->pushCriteria(new SearchByTemplateName($request->get('search')));
        }

        if ($request->get('isActive')) {
            $this->repository->pushCriteria(new SearchByStatus($request->get('isActive')));
        }

        return parent::index($request);
    }
}
