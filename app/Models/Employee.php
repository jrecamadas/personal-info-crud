<?php

namespace App\Models;

use App\Models\Leave\EmployeeLeaveCredit;
use App\Models\Leave\EmployeeLeaveCreditHistory;
use App\Models\Leave\LeaveRequest;
use App\Models\WorkFromHome\WorkFromHomeRequest;
use App\Models\WorkLocation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends BaseModel
{

    const ADV_SEARCH_NAME = 0;
    const ADV_SEARCH_PROJECT = 1;
    const ADV_SEARCH_SKILL = 2;
    const ADV_SEARCH_LOCATION = 3;
    const ADV_SEARCH_CLIENT = 4;

    /**
     * Get Full Name
     */
    public function getName()
    {
        return ucwords(trim($this->last_name . ', ' . $this->first_name . ' ' . $this->middle_name . ' ' . $this->ext));
    }

    /**
     * Get Initial Name (short)
     */
    public function getInitial()
    {
        return ucwords(trim($this->first_name . ' ' . substr($this->last_name, 0, 1)));
    }

    /**
     * User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Active position
     */
    public function positions()
    {
        return $this->hasMany(EmployeeJobPosition::class)->with('position');
    }

    /**
     * Interests
     */
    public function interests()
    {
        return $this->hasMany(EmployeeInterest::class);
    }

    /**
     * Government IDs
     */
    public function governmentIds()
    {
        return $this->hasMany(GovernmentId::class);
    }

    /**
     * Work Shift
     */
    public function shift()
    {
        return $this->hasOne(EmployeeWorkShift::class);
    }

    /**
     * Contact Person
     */
    public function contactPerson()
    {
        return $this->hasOne(ContactPerson::class);
    }

    /**
     * Address
     */
    public function address()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Photo
     */
    public function photo()
    {
        return $this->hasMany(Asset::class, 'assetable_id');
    }

    /**
     * Applicant PDF
     */
    public function pdf()
    {
        return $this->hasMany(Asset::class, 'cv');
    }

    /**
     * Experience
     */
    public function workExperiences()
    {
        // return $this->hasMany(WorkExperience::class)->orderBy('order', 'asc');
        return $this->hasMany(WorkExperience::class)->orderBy('start_date', 'desc');
    }
    /**
     * Skill
     */
    public function skills()
    {
        return $this->hasMany(EmployeeSkill::class)->orderBy('proficiency', 'desc')->with('skill');
    }

    /**
     * Language
     */
    public function languages()
    {
        return $this->hasMany(EmployeeLanguage::class);
    }

    public function educations()
    {
        return $this->hasMany(EmployeeEducation::class)->orderBy('order', 'asc');
    }

    /**
     * Portfolio
     */
    public function portfolios()
    {
        return $this->hasMany(EmployeePortfolio::class);
    }

    /**
     * Department
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Employee Statuses
     */
    public function employeeStatuses()
    {
        return $this->hasMany(EmployeeStatus::class);
    }

    /**
     * Employee Spouse
     */
    public function spouse()
    {
        return $this->hasOne(EmployeeSpouse::class);
    }

    /**
     * Employee Dependent
     */
    public function dependents()
    {
        return $this->hasMany(EmployeeDependent::class)->orderBy('order', 'asc');
    }

    /**
     * Employee Contacts
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Employee Other Skills
     */
    public function otherSkills()
    {
        return $this->hasMany(EmployeeOtherSkill::class);
    }

    /**
     * Employee Other Details
     */
    public function otherDetails()
    {
        return $this->hasMany(EmployeeOtherDetail::class);
    }

    public function projects()
    {
        return $this->hasMany(EmployeeClientProject::class);
    }

    public function employeeReport()
    {
        return $this->hasMany(EmployeeReport::class);
    }

    public function location()
    {
        return $this->hasOne(EmployeeLocation::class);
    }

    public function leaveCredits()
    {
        return $this->hasMany(EmployeeLeaveCredit::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function leaveCreditHistories()
    {
        return $this->hasMany(EmployeeLeaveCreditHistory::class);
    }

    public function preferredTeams()
    {
        return $this->hasMany(ClientPreferredTeam::class)->withTrashed();
    }

    public function workLocation()
    {
        return $this->belongsTo(WorkLocation::class);
    }

    /**
     * get all work from home requests for employee.
     *
     * @return WorkFromHomeRequest
     */
    public function workFromHomeRequests()
    {
        return $this->hasMany(WorkFromHomeRequest::class);
    }
}
