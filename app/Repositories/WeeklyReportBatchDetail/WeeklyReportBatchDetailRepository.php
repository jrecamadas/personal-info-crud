<?php

namespace App\Repositories\WeeklyReportBatchDetail;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Models\WeeklyReportBatchDetail;
use App\Validators\WeeklyReportBatchDetailValidator;

/**
 * Class WeeklyReportBatchDetailRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WeeklyReportBatchDetailRepository extends BaseRepository implements CacheableInterface
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
        return WeeklyReportBatchDetailValidator::class;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WeeklyReportBatchDetail::class;
    }
}
