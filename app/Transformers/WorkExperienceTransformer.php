<?php

namespace App\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use App\Models\WorkExperience;

class WorkExperienceTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'portfolios'
    ];

    public function transform(WorkExperience $experience)
    {
        return [
            'id'                 => (int)$experience->id,
            'employee_id'        => (int)$experience->employee_id,
            'job_title'          => $experience->job_title,
            'company_name'       => $experience->company_name,
            'start_date'         => Carbon::parse($experience->start_date)->format('Y-m-d'),
            'end_date'           => Carbon::parse($experience->end_date)->format('Y-m-d'),
            'description'        => $experience->description,
            'reason_for_leaving' => $experience->reason_for_leaving,
            'order'              => $experience->order
        ];
    }

    /**
     * Include Portfolios
     *
     * @param  WorkExperience $experience
     * @return Collection
     */
    public function includePortfolios(WorkExperience $experience)
    {
        return $this->collection($experience->employeePortfolios, new EmployeePortfolioTransformer());
    }
}
