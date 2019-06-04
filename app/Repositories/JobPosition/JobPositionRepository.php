<?php

namespace App\Repositories\JobPosition;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Models\JobPosition;
use App\Validators\JobPositionValidator;

class JobPositionRepository extends BaseRepository implements CacheableInterface
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
        return JobPositionValidator::class;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return JobPosition::class;
    }
}
