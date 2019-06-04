<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ClientProject;

class ClientProjectTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'client',
        'status'
    ];

    protected $defaultIncludes = [
        'resources'
    ];

    public function transform(ClientProject $project)
    {
        return [
            'id'                  => (int)$project->id,
            'client_id'           => (int)$project->client_id,
            'project_name'        => $project->project_name,
            'project_description' => $project->project_description,
            'project_url'         => $project->project_url,
            'project_requirement' => $project->project_requirement,
            'system_requirement'  => $project->system_requirement,
            'start_date'          => $project->start_date,
            'end_date'            => $project->end_date,
            'status_id'           => $project->status_id,
            'notes'               => $project->notes,
            'color'               => $project->color
        ];
    }

    public function includeClient(ClientProject $project)
    {
        return $this->item($project->client, new CLientTransformer());
    }

    public function includeStatus(ClientProject $project)
    {
        return $this->item($project->status, new CLientProjectStatusTransformer());
    }

    /**
     * Include Project Resources
     *
     * @param ClientProject $project
     * @return Collection
     */
    public function includeResources(ClientProject $project)
    {
        return $this->collection($project->resources, new EmployeeClientProjectTransformer());
    }
}
