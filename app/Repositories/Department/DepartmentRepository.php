<?php

namespace App\Repositories\Department;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Models\Department;
use App\Validators\DepartmentValidator;

class DepartmentRepository extends BaseRepository implements CacheableInterface
{
    use CacheableRepository;

    protected $cacheExcept = [];

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {
        return DepartmentValidator::class;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Department::class;
    }
}
