<?php

namespace App\Repositories\ClientFeedback;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\ClientFeedback\Question;
use App\Traits\SortedRows;
use App\Criterias\ClientFeedback\SearchQuestionByQuestionCategoryId;

class QuestionRepository extends BaseRepository
{

    use SortedRows;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Question::class;
    }

    protected function applyIDFilter($data)
    {
        $id = '';

        if (is_object($data)) {
            $id = $data->questionCategoryId;
        } else {
            $id = $data['questionCategoryId'];
        }

        $constraint = new SearchQuestionByQuestionCategoryId($id);

        return $constraint->apply($this->model, $this);
    }
}
