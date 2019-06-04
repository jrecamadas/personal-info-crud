<?php

namespace App\Repositories\Leave;

use App\Models\Leave\EmployeeLeaveCreditHistory;
use App\Validators\Leave\EmployeeLeaveCreditHistoryValidator;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

class EmployeeLeaveCreditHistoryRepository extends BaseRepository implements CacheableInterface
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
        return EmployeeLeaveCreditHistoryValidator::class;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EmployeeLeaveCreditHistory::class;
    }
}
