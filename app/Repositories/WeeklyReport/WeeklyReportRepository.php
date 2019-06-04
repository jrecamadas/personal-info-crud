<?php
namespace App\Repositories\WeeklyReport;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Models\WeeklyReport;
use App\Validators\WeeklyReportValidator;

/**
 * Class WeeklyReportRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WeeklyReportRepository extends BaseRepository implements CacheableInterface
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
        return WeeklyReportValidator::class;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WeeklyReport::class;
    }
}
