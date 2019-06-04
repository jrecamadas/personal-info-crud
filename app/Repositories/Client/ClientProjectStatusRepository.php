<?php

namespace App\Repositories\Client;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Models\ClientProjectStatus;
use App\Validators\ClientProjectStatusValidator;

class ClientProjectStatusRepository extends BaseRepository implements CacheableInterface
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
        return ClientProjectStatusValidator::class;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ClientProjectStatus::class;
    }
}
