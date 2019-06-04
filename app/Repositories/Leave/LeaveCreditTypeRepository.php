<?php

namespace App\Repositories\Leave;

use App\Models\Leave\LeaveCreditType;
use App\Validators\Leave\LeaveCreditTypeValidator;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

class LeaveCreditTypeRepository extends BaseRepository implements CacheableInterface
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
        return LeaveCreditTypeValidator::class;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LeaveCreditType::class;
    }
}
