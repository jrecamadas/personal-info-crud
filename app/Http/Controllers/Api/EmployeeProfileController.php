<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Employee\EmployeeRepository;
use App\Validators\EmployeeValidator;
use App\Transformers\EmployeeTransformer;
use App\Criterias\Employee\UserNameOrUniqueStrEqualTo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use SnappyPDF;

class EmployeeProfileController extends BaseController
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
            return response()->json(
                [
                'status_code' => 404,
                'message' => 'Can\'t find the requested resource.'
                ], 404
            );
        }
    }

    public function previewPDF($username)
    {
        try {
            $employee       = $this->getUserByUsername($username);
            $portfolios     = $employee->portfolios;
            $skills         = array_slice($employee->skills->getIterator()->getArrayCopy(), 0, 10);
            $languages      = $employee->languages;
            $educations     = $this->getEducation($employee->educations);
            $positions      = $employee->positions;
            $experiences    = $employee->workExperiences;
            $photo          = $employee->photo->where('type', 1)->last();
            $name           = "{$employee->first_name}_{$employee->last_name}".time().".pdf";
            $shift          = $employee->shift;
            $location       = $employee->location;
            $pdf            = SnappyPDF::loadView(
                'employee.pdf',
                compact(
                    'employee',
                    'portfolios',
                    'skills',
                    'languages',
                    'educations',
                    'positions',
                    'photo',
                    'experiences',
                    'shift',
                    'location'
                )
            );
            return $pdf->stream($name);
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                'status_code' => 404,
                'message' => 'Can\'t find the requested resource.'
                ], 404
            );
        }
    }

    private function getEducation($educations) 
    {
        $education = $educations->filter(function ($value, $key) {
            return $value->year_completed == 0;
        });

        $filtered = $educations->filter(function ($value, $key) {
            return $value->year_completed > 0;
        })->sortByDesc(function($item)
        {
            return $item->year_completed;
        });

        return $education->concat($filtered);
    }

    private function getUserByUsername($username)
    {
        $this->repository->pushCriteria(new UserNameOrUniqueStrEqualTo($username));
        return $this->repository->first();
    }
}
