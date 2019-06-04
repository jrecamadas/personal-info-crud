<?php

namespace App\Transformers;

use App\Transformers\WorkFromHome\WorkFromHomeRequestTransformer;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use App\Models\Employee;
use App\Services\EmployeeService;

class EmployeeTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'positions',
        'interests',
        'governmentIds',
        'shift',
        'contactPerson',
        'address',
        'photo',
        'workExperiences',
        'skills',
        'languages',
        'educations',
        'portfolios',
        'department',
        'user',
        'employeeStatuses',
        'spouse',
        'dependents',
        'contacts',
        'otherSkills',
        'otherDetails'
    ];

    protected $defaultIncludes = [
        'projects',
        'location',
        'leaveCredits',
        'leaveRequests',
        'leaveCreditHistories',
        'workFromHomeRequests'
    ];

    public function transform(Employee $employee)
    {
        return [
            'id'                  => (int)$employee->id,
            'department'          => $employee->department_id,
            'employee_no'         => $employee->employee_no,
            'first_name'          => $employee->first_name,
            'last_name'           => $employee->last_name,
            'middle_name'         => $employee->middle_name,
            'nick_name'           => $employee->nick_name,
            'ext'                 => $employee->ext,
            'gender'              => $employee->gender,
            'contact_no'          => $employee->contact_no,
            'email'               => $employee->email,
            'name'                => $employee->getName(),
            'initial'             => $employee->getInitial(),
            'date_of_birth'       => $employee->date_of_birth,
            'civil_status'        => $employee->civil_status,
            'date_hired'          => $employee->date_hired,
            'regularization_date' => $employee->regularization_date,
            'intellicare_id_no'   => $employee->intellicare_id_no,
            'summary'             => $employee->summary,
            'status'              => $employee->status,
            'profile_url'         => EmployeeService::getEmployeeProfileURL($employee),
            'unique_str'          => $employee->unique_str,
            'preferredTeams'      => $employee->preferredTeams,
            'workLocation'        => $employee->workLocation
        ];
    }

    /**
     * Include User
     *
     * @param  Employee $employee
     * @return Item
     */
    public function includeUser(Employee $employee)
    {
        $user = $employee->user;

        if (is_null($user)) {
            return null;
        }

        return $this->item($user, new UserTransformer());
    }

    /**
     * Include positions
     *
     * @param  Employee $employee
     * @return Collection
     */
    public function includePositions(Employee $employee)
    {
        return $this->collection($employee->positions, new EmployeeJobPositionTransformer());
    }

    /**
     * Include Interests
     *EmployeeJobPositionTransformer
     * @param  Employee $employee
     * @return Collection
     */
    public function includeInterests(Employee $employee)
    {
        return $this->collection($employee->interests, new EmployeeInterestTransformer());
    }

    /**
     * Include Government IDs
     *
     * @param  Employee $employee
     * @return Collection
     */
    public function includeGovernmentIds(Employee $employee)
    {
        return $this->collection($employee->governmentIds, new GovernmentIdTransformer());
    }

    /**
     * Include Work Shift
     *
     * @param  Employee $employee
     * @return Item
     */
    public function includeShift(Employee $employee)
    {
        $shift = $employee->shift;

        if (is_null($shift)) {
            return null;
        }

        return $this->item($shift, new EmployeeWorkShiftTransformer());
    }

    /**
     * Include Contact Person
     *
     * @param  Employee $employee
     * @return Item
     */
    public function includeContactPerson(Employee $employee)
    {
        $contactPerson = $employee->contactPerson;

        if (is_null($contactPerson)) {
            return null;
        }

        return $this->item($contactPerson, new ContactPersonTransformer());
    }

    /**
     * Include Address
     *
     * @param  Employee $employee
     * @return Collection
     */
    public function includeAddress(Employee $employee)
    {
        return $this->collection($employee->address, new AddressTransformer());
    }

    /**
     * Include Photo
     *
     * @param  Employee $employee
     * @return Collection
     */
    public function includePhoto(Employee $employee)
    {
        return $this->collection($employee->photo, new AssetTransformer());
    }
    /**
     * Include Experience
     *
     * @param  Employee $employee
     * @return Collection
     */
    public function includeWorkExperiences(Employee $employee)
    {
        return $this->collection($employee->workExperiences, new WorkExperienceTransformer());
    }
    /**
     * Include Skills
     *
     * @param  Employee $employee
     * @return Collection
     */
    public function includeSkills(Employee $employee)
    {
        return $this->collection($employee->skills, new EmployeeSkillTransformer());
    }

    /**
     * Include Skills
     *
     * @param  Employee $employee
     * @return Collection
     */
    public function includeLanguages(Employee $employee)
    {
        return $this->collection($employee->languages, new EmployeeLanguageTransformer());
    }

    /**
     * Include Educations
     *
     * @param  Employee $employee
     * @return Collection
     */
    public function includeEducations(Employee $employee)
    {
        return $this->collection($employee->educations, new EmployeeEducationTransformer());
    }

    /**
     * Include Portfolio
     */
    public function includePortfolios(Employee $employee)
    {
        return $this->collection($employee->portfolios, new EmployeePortfolioTransformer());
    }

    /**
     * Include Department
     */
    public function includeDepartment(Employee $employee)
    {
        $department = $employee->department;

        if (is_null($department)) {
            return null;
        }

        return $this->item($department, new DepartmentTransformer());
    }

    public function includeEmployeeStatuses(Employee $employee)
    {
        return $this->collection($employee->employeeStatuses, new EmployeeStatusTransformer());
    }

    /**
     * Include Employee Spouse
     *
     * @param  Employee $employee
     * @return Item
     */
    public function includeSpouse(Employee $employee)
    {
        $spouse = $employee->spouse;

        if (is_null($spouse)) {
            return null;
        }

        return $this->item($spouse, new EmployeeSpouseTransformer());
    }

    /**
     * Include Employee Dependent
     *
     * @param  Employee $employee
     * @return Collection
     */
    public function includeDependents(Employee $employee)
    {
        return $this->collection($employee->dependents, new EmployeeDependentTransformer());
    }

    /**
     * Include Employee Contacts
     *
     * @param Employee $employee
     * @return Collection
     */
    public function includeContacts(Employee $employee)
    {
        return $this->collection($employee->contacts, new ContactTransformer());
    }

    /**
     * Include Employee Other Skills
     *
     * @param Employee $employee
     * @return Collection
     */
    public function includeOtherSkills(Employee $employee)
    {
        return $this->collection($employee->otherSkills, new EmployeeOtherSkillTransformer());
    }

    /**
     * Include Employee Other Details
     *
     * @param Employee $employee
     * @return Collection
     */
    public function includeOtherDetails(Employee $employee)
    {
        return $this->collection($employee->otherDetails, new EmployeeOtherDetailTransformer());
    }

    /**
     * Include Employee Projects
     *
     * @param  Employee $employee
     * @return Collection
     */
    public function includeProjects(Employee $employee)
    {
        return $this->collection($employee->projects, new EmployeeClientProjectTransformer());
    }

    /**
     * Include Employee Location
     *
     * @param  Employee $employee
     * @return Item
     */
    public function includeLocation(Employee $employee)
    {
        $location = $employee->location;

        if (is_null($location)) {
            return null;
        }

        return $this->item($location, new EmployeeLocationTransformer());
    }

    /**
     * Include Employee LeaveCredits
     *
     * @param  Employee $employee
     * @return Item
     */
    public function includeLeaveCredits(Employee $employee)
    {
        return $this->collection($employee->leaveCredits, new Leave\EmployeeLeaveCreditTransformer());
    }

    /**
     * Include Employee LeaveRequests
     *
     * @param  Employee $employee
     * @return Item
     */
    public function includeLeaveRequests(Employee $employee)
    {
        return $this->collection($employee->leaveRequests, new Leave\LeaveRequestTransformer());
    }

    /**
     * Include Employee LeaveCredits
     *
     * @param  Employee $employee
     * @return Item
     */
    public function includeLeaveCreditHistories(Employee $employee)
    {
        return $this->collection($employee->leaveCreditHistories, new Leave\EmployeeLeaveCreditHistoryTransformer());
    }

    /**
     * Include Employee Work From Home Requests
     *
     * @param Employee $employee
     * @return Collection
     */
    public function includeWorkFromHomeRequests(Employee $employee)
    {
        return $this->collection($employee->workFromHomeRequests, new WorkFromHomeRequestTransformer());
    }
}
