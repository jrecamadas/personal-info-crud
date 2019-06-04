<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ReferralType;

/**
 * Class ReferralTypeTransformer.
 *
 * @package namespace App\Transformers;
 */
class ReferralTypeTransformer extends TransformerAbstract
{
    /**
     * Transform the ReferralType entity.
     *
     * @param \App\Entities\ReferralType $model
     *
     * @return array
     */
    public function transform(ReferralType $model)
    {
        return [
            'id'         => (int)$model->id,
            'name'       => $model->name
        ];
    }
}
