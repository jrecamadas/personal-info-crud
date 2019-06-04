<?php

namespace App\Repositories\ACL;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Models\ACL\ResourceRolePermission;
use App\Validators\ACL\ResourceRolePermissionValidator;

class ResourceRolePermissionRepository extends BaseRepository implements CacheableInterface
{
    use CacheableRepository;

    protected $cacheExcept = [];

    /**
     * Sepcify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {
        return ResourceRolePermissionValidator::class;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ResourceRolePermission::class;
    }
}
