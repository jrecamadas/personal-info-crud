<?php

namespace App\Repositories\Contact;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Models\Contact;
use App\Validators\ContactValidator;

class ContactRepository extends BaseRepository implements CacheableInterface
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
        return ContactValidator::class;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Contact::class;
    }
}
