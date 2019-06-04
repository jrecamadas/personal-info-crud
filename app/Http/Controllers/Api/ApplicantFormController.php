<?php

namespace App\Http\Controllers\Api;

use App\Criterias\Employee\UserNameOrUniqueStrEqualTo;
use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Models\User;
use App\Repositories\Employee\EmployeeRepository;
use App\Transformers\EmployeeTransformer;
use App\Validators\EmployeeValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use SnappyPDF;

class ApplicantFormController extends BaseController
{
    public function __construct(EmployeeRepository $repository, EmployeeValidator $validator, EmployeeTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    public function show($userName)
    {
        try {
            $result = $this->getUserByUsername($userName);
            return $this->response->item($result, $this->transformer);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status_code' => 404,
                'message' => 'Can\'t find the requested resource.',
            ], 404);
        }
    }

    public function previewPDF($username)
    {
        try {
            $employee = $this->getUserByUsername($username);
            $portfolios = $employee->portfolios;
            $skills = array_slice($employee->skills->getIterator()->getArrayCopy(), 0, 10);
            $languages = $employee->languages;
            $educations = $employee->educations;
            $positions = $employee->positions;
            $experiences = $employee->workExperiences;
            $photo = $employee->photo->where('type', 1);
            $name = "{$employee->first_name}_{$employee->last_name}" . time() . ".pdf";
            $pdf = SnappyPDF::loadView(
                'employee.pdf',
                compact(
                    'employee',
                    'portfolios',
                    'skills',
                    'languages',
                    'educations',
                    'positions',
                    'photo',
                    'experiences'
                )
            );
            return $pdf->stream($name);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status_code' => 404,
                'message' => 'Can\'t find the requested resource.',
            ], 404);
        }
    }

    public function tokenize()
    {
        $authenticated = false;
        $responseMessage = 'Unauthenticated';
        $responseCode = 401;
        $additionalData = [];

        $referrer = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        $applicantUrl = env('APP_URL') . '/applicant';
        $clientUrl = env('APP_URL') . '/client-onboarding';
        if (strcmp($applicantUrl, $referrer) === 0 || strcmp($clientUrl, $referrer) === 0) {
            $publicUsername = 'public_applicant_form_user';
            $publicUser = User::where([
                'user_name' => $publicUsername,
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

    private function getUserByUsername($username)
    {
        $this->repository->pushCriteria(new UserNameOrUniqueStrEqualTo($username));
        return $this->repository->first();
    }
}