<?php
namespace App\Repositories\ClientProjectJobcode;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Models\ClientProjectJobcode;
use App\Validators\ClientProjectJobcodeValidator;

/**
 * Interface ClientProjectJobCodeRepository.
 *
 * @package namespace App\Repositories;
 */
class ClientProjectJobcodeRepository extends BaseRepository implements CacheableInterface
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
        return ClientProjectJobcodeValidator::class;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ClientProjectJobcode::class;
    }
}
