<?php
namespace App\Transformers\Leave;

use App\Models\Leave\LeaveCreditType;
use League\Fractal\TransformerAbstract;


class LeaveCreditTypeTransformer extends TransformerAbstract
{
    public function transform(LeaveCreditType $model)
    {
        return [
            'id'    => (int)$model->id,
            'name'  => $model->name,
            'limit' => $model->limit
        ];
    }
}
