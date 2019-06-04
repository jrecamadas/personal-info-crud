<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\PreEmploymentChecklist;
use App\Transformers\EmployeeChecklistTransformer;
use App\Models\EmployeeChecklist;
use App\Transformers\PreEmploymentChecklistTransformer;
use App\Models\Asset;

/**
 * Class PreEmploymentChecklistTransformer.
 *
 * @package namespace App\Transformers;
 */
class PreEmploymentChecklistTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'eChecklist',
    ];

    /**
     * Transform the PreEmploymentChecklist entity.
     *
     * @param \App\Entities\PreEmploymentChecklist $model
     *
     * @return array
     */
    public function transform(PreEmploymentChecklist $checklist)
    {
        return [
            'id'          => (int) $checklist->id,
            'group'       => $checklist->group,
            'document'    => $checklist->document,
            'description' => $checklist->description,
        ];
    }

    public function includeEChecklist(PreEmploymentChecklist $checklist)
    {
        $checklist = $checklist->EChecklist;
        
        if (is_null($checklist)) {
            return null;
        }

        return $this->item($checklist, new EmployeeChecklistTransformer());
    }
}