<?php

namespace App\Repositories\ClientFeedback;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\ClientFeedback\QuestionCategory;
use App\Traits\SortedRows;
use App\Criterias\ClientFeedback\SearchQuestionCategoriesByQuestionnaireId;

class QuestionCategoryRepository extends BaseRepository
{
    use SortedRows;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return QuestionCategory::class;
    }

    protected function applyIDFilter($data)
    {
        $id = '';

        if (is_object($data)) {
            $id = $data->questionnaireId;
        } else {
            $id = $data['questionnaireId'];
        }

        $constraint = new SearchQuestionCategoriesByQuestionnaireId($id);

        return $constraint->apply($this->model, $this);
    }
}
