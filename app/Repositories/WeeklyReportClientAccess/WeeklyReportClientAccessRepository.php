<?php
namespace App\Repositories\WeeklyReportCientAccess;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Models\WeeklyReportClientAccess;
use App\Validators\WeeklyReportClientAccessValidator;

/**
 * Class WeeklyReportClientAccessRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WeeklyReportClientAccessRepository extends BaseRepository implements CacheableInterface
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
        return WeeklyReportClientAccessValidator::class;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WeeklyReportClientAccess::class;
    }
}
