<?php

namespace App\Http\Controllers\Api\Secured\ClientFeedback;

use App\Transformers\ClientFeedback\ProjectSurveyTransformer;
use App\Repositories\ClientFeedback\ProjectSurveyRepository;
use App\Repositories\ClientFeedback\SurveySentRepository;
use App\Validators\ClientFeedback\ProjectSurveyValidator;
use App\Criterias\Client\SearchByClientId;
use App\Criterias\ClientFeedback\SearchBySurveyName;
use App\Criterias\ClientFeedback\SearchByFilter;
use Dingo\Api\Http\Request;
use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Traits\CleanPostData;

class ProjectSurveysController extends BaseController
{
    use CleanPostData;

    public function __construct(
        ProjectSurveyRepository $repository,
        ProjectSurveyTransformer $transformer,
        ProjectSurveyValidator $validator
    ) {
        $this->repository = $repository;
        $this->transformer = $transformer;
        $this->validator = $validator;
    }

    /**
     *
     * GET Survey by a Client Id
     *
     *  @param Request $request
     *  @return Resource
     *  @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     */
    public function index(Request $request)
    {
        if ($request->has('clientId')) {
            $this->repository->pushCriteria(new SearchByClientId($request->get('clientId')));
        }

        if ($request->get('search')) {
            $this->repository->pushCriteria(new SearchBySurveyName($request->get('search')));
        }

        if ($request->has('filters')) {
            $filter = explode('|', $request->get('filters'));
            $this->repository->pushCriteria(new SearchByFilter($filter[0], $filter[1]));
        }

        return parent::index($request);
    }

    public function destroy ($id)
    {
        // Delete first its email recipients
        $survey = $this->repository->find($id);
        $recipients = $survey->recipients->pluck('id')->toArray();
        $survey->recipients()->whereIn('id', $recipients)->forceDelete();

        return parent::destroy($id);
    }

    public function manualSend(Request $request, $id)
    {
        $survey = $this->repository->find($id);

        if (!is_null($survey)) {
            try {
                $this->validator->with($request->all())->passesOrFail('manual-send');

                $ssr = \App::make(SurveySentRepository::class);

                $ssr->sendSurvey($survey, $request->all());

                return response()->json([
                    'status_code' => 204,
                    'message' => 'done'
                ], 204);
            } catch (ValidatorException $e) {
                return response()->json([
                    'status_code' => 400,
                    'message' => $e->getMessageBag()
                ], 400);
            }
        } else {
            return response()->json([
                'status_code' => 404,
                'message' => 'Can\'t find the requested resource.'
            ], 404);
        }
    }
}
