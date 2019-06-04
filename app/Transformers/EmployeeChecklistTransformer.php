<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\EmployeeChecklist;
use App\Models\Asset;

/**
 * Class EmployeeChecklistTransformer.
 *
 * @package namespace App\Transformers;
 */
class EmployeeChecklistTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'asset',
    ];

    /**
     * Transform the EmployeeChecklist entity.
     *
     * @param \App\Entities\EmployeeChecklist $model
     *
     * @return array
     */
    public function transform(EmployeeChecklist $checklist)
    {
        return [
            'id'                          => (int)$checklist->id,
            'employee_id'                 => $checklist->employee_id,
            'pre_employment_checklist_id' => $checklist->pre_employment_checklist_id,
            'created_at'                  => $checklist->created_at,
            'updated_at'                  => $checklist->updated_at,
        ];
    }

    public function includeAsset(EmployeeChecklist $checklist)
    {
        $checklist = $checklist->asset;

        if (is_null($checklist)) {
            return null;
        }

        return $this->item($checklist, new AssetTransformer());
    }
}
