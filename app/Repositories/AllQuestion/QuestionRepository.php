<?php

namespace App\Repositories\AllQuestion;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\AllQuestion;
use App\Validators\AllQuestion\QuestionValidator as AllQuestionValidator;

/**
 * Class QuestionRepository.
 *
 * @package namespace App\Repositories\AllQuestion;
 */
class QuestionRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AllQuestion::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {
        return AllQuestionValidator::class;
    }
}
