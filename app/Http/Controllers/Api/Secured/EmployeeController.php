<?php

namespace App\Http\Controllers\Api\Secured;

use App\Criterias\Employee\EmployeeOnly;
use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Models\Employee;
use App\Repositories\Employee\EmployeeRepository;
use App\Validators\EmployeeValidator;
use App\Transformers\EmployeeTransformer;
use Dingo\Api\Http\Request;
use App\Criterias\Common\WithTrashed;
use App\Criterias\Employee\SearchByEmployeeNo;
use App\Criterias\Employee\SearchByNameOrFullName;
use App\Criterias\Employee\SearchBySkill;
use App\Criterias\Employee\WithEmployeeSkill;
use App\Criterias\Employee\SearchNotAssigned;
use App\Criterias\Employee\WithPosition;
use App\Criterias\Employee\FilterByJobTitle;
use App\Criterias\Employee\FilterByStatus;
use App\Criterias\Employee\FilterByProject;
use App\Criterias\Employee\FilterByLocation;
use App\Criterias\Employee\FilterByEmployeeNumber;
use App\Criterias\Employee\FilterByUnassigned;
use App\Criterias\Employee\FilterByName;
use App\Criterias\Employee\FilterByEmployeeStatus;
use App\Criterias\Employee\FilterByDepartment;
use App\Criterias\Employee\FilterByClient;
use App\Criterias\Employee\WithStatus;
use App\Criterias\Employee\WithDepartment;
use App\Criterias\Employee\Select;
use App\Criterias\Employee\SearchByUser;
use App\Criterias\Employee\ApplicantOnly;
use App\Criterias\Employee\EmployeeNoFilter;
use App\Criterias\Employee\FilterByUserId;
use App\Criterias\Employee\WithClientProject;
use App\Criterias\Employee\WithLocation;
use App\Criterias\Employee\SearchAll;
use App\Criterias\Employee\SearchAdvanced;
use App\Criterias\Employee\SearchBySkillAndUnassigned;
use App\Criterias\Employee\SearchByUnassignedAndEmployeeDB;
use App\Criterias\Employee\SearchByClientAndUnpreferred;
use App\Criterias\Employee\WithClientPreferredTeam;
use App\Criterias\Employee\SearchByJobTitles;
use App\Criterias\Employee\SearchByDeveloper;

class EmployeeController extends BaseController
{
    public function __construct(EmployeeRepository $repository, EmployeeValidator $validator, EmployeeTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    /**
     * Get list of employees
     *
     * @return Collection
     */
    public function index(Request $request)
    {
        // filter by applicants/employees only
        if ($request->get('applicants')) {
            // add SearchByName criteria
            $this->repository->pushCriteria(new ApplicantOnly($request->get('applicants')));
        } else if ($request->get('resources')) {
            $this->repository->pushCriteria(new SearchNotAssigned($request->get('resources')));
        } else {
            $this->repository->pushCriteria(new EmployeeOnly($request->get('take')));
            $filter = !empty($request->get('filters')) ? explode('|', $request->get('filters')) : '';
            if (empty($request->get('search')) && empty($filter[0])) {
                $this->repository->pushCriteria(new FilterByStatus([16, 18, 19])); //probationary & regular
            }
        }

        if ($request->get('skills')) {
            $skills = explode(',', $request->get('skills'));
            $this->repository->pushCriteria(new SearchBySkillAndUnassigned($skills));
        } else if ($request->get('unassigned')) {
            $this->repository->pushCriteria(new SearchByUnassignedAndEmployeeDB($request->get('unassigned')));
        }

        if($request->get('developerSkills') && $request->get('clientTeam')){
            $developerSkills = explode(',', $request->get('developerSkills'));
            $this->repository->pushCriteria(new WithClientPreferredTeam());
            $this->repository->pushCriteria(new SearchByDeveloper());
            $this->repository->pushCriteria(new SearchBySkillAndUnassigned($developerSkills));
            $this->repository->pushCriteria(new SearchByClientAndUnpreferred($request->get('clientTeam')));
        }

        if($request->get('positions')){
            $positions = explode(',', $request->get('positions'));
            $this->repository->pushCriteria(new SearchByJobTitles($positions));
        }

        // TODO: remove advance search
        // see if we have searches
        if ($request->get('search')) {
            /*
            switch ($request->get('searchBy')) {
                case 'skill':
                    $this->repository->pushCriteria(new WithEmployeeSkill());
                    $this->repository->pushCriteria(new SearchBySkill($request->get('search')));
                    break;
                case 'empID':
                    $this->repository->pushCriteria(new SearchByEmployeeNo($request->get('search')));
                    break;
                default:
                    $this->repository->pushCriteria(new SearchByNameOrFullName($request->get('search')));
                    break;
            }*/

            //Splits the formatted search into an array for the name, project, skill and location
            $advSearchArr = preg_split('/<name>:|<project>:|<skill>:|<location>:|<client>:/', $request->get('search'));
            array_shift($advSearchArr);
            //If there is a format '<name>:<project>:<skill>:<location>:' in the search, then use the advance search
            //else use the general search
            if (count($advSearchArr) == 5) {
                //To separate and get the different values selected in the advanced search
                $nameArr = explode('$|$', str_replace([' ', ','], '', $advSearchArr[0]));
                $projectArr = explode('$|$', $advSearchArr[1]);
                $skillArr = explode('$|$', $advSearchArr[2]);
                $locationArr = explode('$|$', str_replace([' ', ','], '', $advSearchArr[3]));
                $clientArr = explode('$|$', $advSearchArr[4]);

                $this->repository->pushCriteria(new SearchAdvanced($nameArr, $projectArr, $skillArr, $locationArr, $clientArr));
            } else {
                $this->repository->pushCriteria(new SearchAll($request->get('search')));
            }
        }

        // see if we should be including those deleted employees
        if ($request->get('withTrashed')) {
            // include deleted employees
            $this->repository->pushCriteria(new WithTrashed());
        }

        // filter by users id
        if ($request->get('user_id')) {
            $this->repository->pushCriteria(new SearchByUser($request->get('user_id')));
        }

        // filter by job title
        if ($request->get('filters')) {
            $filter = explode('|', $request->get('filters'));

            switch ($filter[0]) {
                case 'applicant_list':
                    if ($filter[1] !== '0') {
                        $this->repository->pushCriteria(new FilterByJobTitle($filter[1]));
                    }
                    if ($filter[2] !== '0') {
                        $this->repository->pushCriteria(new FilterByStatus([$filter[2]]));
                    }
                    break;
                case 'employee_list':
                    if (!empty($filter[1])) {
                        $this->repository->pushCriteria(new FilterByEmployeeNumber($filter[1]));
                    }

                    if (!empty($filter[2])) {
                        $names = explode(", ", $filter[2]);
                        $name = explode(" ", $names[1]);
                        if (sizeof($name) > 1)
                            array_pop($name);
                        $firstName = implode(" ", $name);
                        $this->repository->pushCriteria(new FilterByName(trim($firstName), trim($names[0])));
                    }

                    if (!empty($filter[3])) {
                        if ($filter[3] !== 'Unassigned') {
                            $this->repository->pushCriteria(new FilterByProject($filter[3]));
                        } else {
                            $this->repository->pushCriteria(new FilterByUnassigned($filter[3]));
                        }
                    }

                    if (!empty($filter[4])) {
                        $location = explode(", ", $filter[4]);
                        $this->repository->pushCriteria(new FilterByLocation($location[0], $location[1]));
                    }

                    if (!empty($filter[5])) {
                        $this->repository->pushCriteria(new FilterByStatus([$filter[5]]));
                    }

                    if (!empty($filter[6])) {
                        $this->repository->pushCriteria(new FilterByClient($filter[6]));
                    }

                    // if ($filter[1] !== '0') {
                    //     $this->repository->pushCriteria(new FilterByJobTitle($filter[1]));
                    // }
                    // if ($filter[2] !== '0') {
                    //     $this->repository->pushCriteria(new FilterByDepartment($filter[2]));
                    // }
                    // if ($filter[3] !== '0') {
                    //     $empStatusFilter = ($filter[3] == '1')
                    //         ? $this->repository->pushCriteria(new FilterByEmployeeStatus('Assigned'))
                    //         : $this->repository->pushCriteria(new FilterByEmployeeStatus('Available'));
                    // }
                    break;
            }
        }


        // checks availability of employee no.
        if ($request->get('employeeNo')) {
            $this->repository->pushCriteria(new WithTrashed());
            $this->repository->pushCriteria(new EmployeeNoFilter($request->get('employeeNo')));
        }

        if ($request->get('user_id')) {
            $this->repository->pushCriteria(new FilterByUserId($request->get('user_id')));
        }

        // TODO: replace this to defaultCriteria()
        // default criteria
        $this->repository->pushCriteria(new WithDepartment());
        $this->repository->pushCriteria(new WithPosition());
        $this->repository->pushCriteria(new WithStatus());
        $this->repository->pushCriteria(new WithLocation());
        $this->repository->pushCriteria(new WithClientProject());
        $this->repository->pushCriteria(new WithEmployeeSkill());
        $this->repository->pushCriteria(new Select());

        return parent::index($request);
    }

    /**
     * Use for Advance Search
     *
     * @param Request $request
     * @return Collection;
     */
    public function advanceSearch(Request $request)
    {
        //Splits the formatted search into an array for the name, project, skill and location
        $advSearchArr = preg_split('/<name>:|<project>:|<skill>:|<location>:|<client>:/', $request->get('search'));

        // remove first empty element in array
        array_shift($advSearchArr);

        //To separate and get the different values selected in the advanced search
        $nameArr = explode('$|$', str_replace([' ', ','], '', $advSearchArr[Employee::ADV_SEARCH_NAME]));
        $projectArr = explode('$|$', $advSearchArr[Employee::ADV_SEARCH_PROJECT]);
        $skillArr = explode('$|$', $advSearchArr[Employee::ADV_SEARCH_SKILL]);
        $locationArr = explode('$|$', str_replace([' ', ','], '', $advSearchArr[Employee::ADV_SEARCH_LOCATION]));
        $clientArr = explode('$|$', $advSearchArr[Employee::ADV_SEARCH_CLIENT]);

        $this->repository->pushCriteria(new SearchAdvanced($nameArr, $projectArr, $skillArr, $locationArr, $clientArr));

        // load default criteria
        $this->defaultCriteria();

        return parent::index($request);
    }

    /**
     * Default criteria for employee
     *
     * @return void;
     */
    private function defaultCriteria()
    {
        $this->repository->pushCriteria(new WithDepartment());
        $this->repository->pushCriteria(new WithPosition());
        $this->repository->pushCriteria(new WithStatus());
        $this->repository->pushCriteria(new WithLocation());
        $this->repository->pushCriteria(new WithClientProject());
        $this->repository->pushCriteria(new WithEmployeeSkill());
        $this->repository->pushCriteria(new Select());
    }
}
