<?php
namespace App\Repositories\WeeklyReportBatch;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Validators\WeeklyReportBatchValidator;
use App\Models\WeeklyReportBatch;

/**
 * Class WeeklyReportBatchRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WeeklyReportBatchRepository extends BaseRepository implements CacheableInterface
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
        return WeeklyReportBatchValidator::class;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WeeklyReportBatch::class;
    }
}
