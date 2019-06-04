<?php

namespace App\Repositories\WorkFromHome;

use App\Models\WorkFromHome\WorkFromHomeRequest;
use App\Validators\WorkFromHome\WorkFromHomeRequestValidator;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;

class WorkFromHomeRequestRepository extends BaseRepository implements CacheableInterface
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
        return WorkFromHomeRequestValidator::class;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WorkFromHomeRequest::class;
    }

    public function fetchForSending()
    {
        return $this->model->where('notified_at', null)->limit(config('email.limit', 50))->get();
    }

    public function markAsSent($workFromHome)
    {
        $this->model->find($workFromHome->id)->update(array('notified_at' => date("Y-m-d H:i:s")));
    }
}
