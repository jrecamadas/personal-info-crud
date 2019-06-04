<?php
namespace App\Repositories\ClientPreferredTeam;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Models\ClientPreferredTeam;
use App\Validators\ClientPreferredTeamValidator;

/**
 * Interface ClientPreferredTeamRepository.
 *
 * @package namespace App\Repositories;
 */
class ClientPreferredTeamRepository extends BaseRepository implements CacheableInterface
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
        return ClientPreferredTeamValidator::class;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ClientPreferredTeam::class;
    }
}
