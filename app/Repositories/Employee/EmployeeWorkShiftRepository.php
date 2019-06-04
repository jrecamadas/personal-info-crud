<?php

namespace App\Repositories\Employee;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Models\EmployeeWorkShift;
use App\Validators\EmployeeWorkShiftValidator;

class EmployeeWorkShiftRepository extends BaseRepository implements CacheableInterface
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
        return EmployeeWorkShiftValidator::class;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EmployeeWorkShift::class;
    }
}
