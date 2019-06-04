<?php

namespace App\Repositories\Employee;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Models\ContactPerson;
use App\Validators\ContactPersonValidator;

class ContactPersonRepository extends BaseRepository implements CacheableInterface
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
        return ContactPersonValidator::class;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ContactPerson::class;
    }
}
