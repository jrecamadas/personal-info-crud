<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ClientPreferredTeam;
use App\Services\EmployeeService;

class ClientPreferredTeamTransformer extends TransformerAbstract
{
    public function transform(ClientPreferredTeam $preferredTeam)
    {
        return [
            'id'             => (int)$preferredTeam->id,
            'client'         => $preferredTeam->client,
            'client_project' => $preferredTeam->clientProject,
            'employee'       => $preferredTeam->employee,
            'job_position'   => $preferredTeam->jobPosition,
            'positions'      => EmployeeService::getEmployeePositions($preferredTeam->employee),
            'skills'         => $preferredTeam->employee->skills,
            'photo'          => $preferredTeam->employee->photo,
            'profile_url'    => EmployeeService::getEmployeeProfileURL($preferredTeam->employee)
        ];
    }
}
