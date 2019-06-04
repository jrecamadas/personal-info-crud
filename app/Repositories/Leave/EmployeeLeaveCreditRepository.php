<?php

namespace App\Repositories\Leave;

use App\Models\Leave\EmployeeLeaveCredit;
use App\Validators\Leave\EmployeeLeaveCreditValidator;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

class EmployeeLeaveCreditRepository extends BaseRepository implements CacheableInterface
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
        return EmployeeLeaveCreditValidator::class;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EmployeeLeaveCredit::class;
    }
}
