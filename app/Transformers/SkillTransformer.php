<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Skill;

class SkillTransformer extends TransformerAbstract
{
    public function transform(Skill $skill)
    {
        return [
            'id'          => (int)$skill->id,
            'name'        => $skill->name,
            'description' => $skill->description,
            'deleted_at'  => $skill->deleted_at
        ];
    }
}
