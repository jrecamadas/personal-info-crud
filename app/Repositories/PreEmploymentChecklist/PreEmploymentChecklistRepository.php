<?php

namespace App\Repositories\PreEmploymentChecklist;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Models\PreEmploymentChecklist;
use App\Validators\PreEmploymentChecklistValidator;

class PreEmploymentChecklistRepository extends BaseRepository implements CacheableInterface
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
        return PreEmploymentChecklistValidator::class;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PreEmploymentChecklist::class;
    }
}
