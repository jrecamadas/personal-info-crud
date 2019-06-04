<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\User;

class UserTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'employee',
        'employeeId'
    ];

    protected $defaultIncludes = [
        'roles'
    ];

    public function transform(User $user)
    {
        return [
            'id'          => (int)$user->id,
            'email'       => $user->email,
            'user_name'   => $user->user_name,
            'can_login'   => $user->can_login,
            'is_verified' => $user->is_verified,
            'updated_at'  => !is_null($user->updated_at) ? $user->updated_at->format('Y-m-d H:m:s') : null,
            'updated_by'  => $user->getUpdatedByUser()
        ];
    }

    public function includeEmployee(User $user)
    {
        $employee = $user->employee;

        if (is_null($employee)) {
            return null;
        }

        return $this->item($employee, new EmployeeTransformer());
    }

    public function includeEmployeeId(User $user)
    {
        $employee = $user->employeeId;

        if (is_null($employee)) {
            return null;
        }

        return $this->item($employee, new EmployeeTransformer());
    }

    public function includeRoles(User $user)
    {
        return $this->collection($user->roles, new \App\Transformers\ACL\UserRoleTransformer());
    }
}
