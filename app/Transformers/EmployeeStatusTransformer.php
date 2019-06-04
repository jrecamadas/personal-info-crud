<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\EmployeeStatus;

/**
 * Class EmployeePortfolioTransformer.
 *
 * @package namespace App\Transformers;
 */
class EmployeeStatusTransformer extends TransformerAbstract
{
    /**
     * Transform the EmployeePortfolio entity.
     *
     * @param \App\Models\EmployeePortfolio $model
     *
     * @return array
     */
    public function transform(EmployeeStatus $model)
    {
        return [
            'updated_by' => $model->user->user_name,
            'status'     => $model->status,
            'updated_at' => $model->created_at
        ];
    }
}
