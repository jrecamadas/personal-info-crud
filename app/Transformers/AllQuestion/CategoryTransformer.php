<?php

namespace App\Transformers\AllQuestion;

use League\Fractal\TransformerAbstract;
use App\Models\AllQuestionCategory;
use App\Services\HelpersService;

class CategoryTransformer extends TransformerAbstract
{
    public function transform(AllQuestionCategory $category)
    {
        return [
            'id'         => (int)$category->id,
            'name'       => $category->name,
            'created_at' => HelpersService::parseCreatedDateTimeFromDb($category->created_at),
        ];
    }
}
