<?php

namespace App\Http\Controllers\Api;

use App;
use Mail;
use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Transformers\ClientFeedback\SurveySentTransformer;
use App\Repositories\ClientFeedback\SurveySentRepository;
use App\Validators\ClientFeedback\SurveySentValidator;
use App\Criterias\ClientFeedback\SearchSurveySentBySurveyLink;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Dingo\Api\Http\Request;
use App\Models\User;
use App\Models\EmailTemplate as EmailTemplateForSending;
use App\Models\EmailDetails;
use App\Mail\EmailItem;

class SurveyController extends BaseController
{
    public function __construct(
        SurveySentRepository $repository,
        SurveySentValidator $validator,
        SurveySentTransformer $transformer
    ) {
        $this->repository = $repository;
        $this->transformer = $transformer;
        $this->validator = $validator;
    }

    public function index(Request $request)
    {
        if ($request->has('surveyLink')) {
            $link = $request->get('surveyLink');
            $criteria = new SearchSurveySentBySurveyLink($link);
            try {
                $survey = $this->repository->pushCriteria($criteria);
                return $this->response->item(
                    $survey->first(),
                    $this->transformer
                );
            } catch (ModelNotFoundException $e) {
                return response()->json(
                    [
                        'status_code' => 404,
                        'message' => 'Can\'t find the survey'
                    ],
                    404
                );
            }
        }
    }

    public function tokenize($link)
    {
        $authenticated = false;
        $responseMessage = 'Unauthenticated';
        $responseCode = 401;
        $additionalData = [];
        
        $referrer = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        $url = env('APP_URL') . '/survey' . '/' . $link;
        
        if (strcmp($url, $referrer) === 0) {
            $userClient = 'client_survey_response';
            $publicUser = User::where([
                'user_name' => $userClient,
            ])->first();
            
            if (!empty($publicUser)) {
                $token = $publicUser->createToken('')->accessToken;
                $responseCode = 200;
                $responseMessage = 'Authenticated';
                $authenticated = true;
                $additionalData['accessToken'] = $token;
            }
        } else {
            \Log::warning(
                'Someone is accessing this API in another page. Please check log details!',
                [
                    'url_accessor' => $referrer,
                    'url_api' => $_SERVER['REQUEST_URI'],
                    'date' => date('Y-m-d H:i:s'),
                ]
            );
        }

        $responseData = [
            'status_code' => $responseCode,
            'message' => $responseMessage,
            'authenticated' => $authenticated,
        ];

        return response()->json(array_merge($responseData, $additionalData), $responseCode);
    }

    public function sendSurveySubmittedNotification(Request $request)
    {
        $responderName = $request->get('name');
        $link = url('/survey/responses/'.$request->get('link'));

        $subject = 'Client Survey Responded';
        $body = '<p>Hi,</p><p>&nbsp;</p><p>This is to notify that client {{$responderName}} has already responded the survey.</p><p>&nbsp;</p><p>Please navigate to this <a href="{{$link}}">link</a> to view the response.</p><p>&nbsp;</p><p>Thank you.</p>';

        $to = [
            'mgalanido@fullscale.io',
            'vestadillo@fullscale.io',
            'varbonida@fullscale.io'
        ];
        if (strtolower(trim(App::Environment())) == 'prod') {
            $to = [
                'spilayre@fullscale.io',
                'esinena@fullscale.io',
            ];
        }

        $details = new EmailDetails();

        foreach($to as $recipient) {
            $details->addTo($recipient);
        }

        $template = new EmailTemplateForSending();

        $template->setTemplate($subject, $body);

        $details->template = $template;
        $details->addData('responderName', $responderName);
        $details->addData('link', $link);
        
        Mail::send(new EmailItem($details));
    }
}
