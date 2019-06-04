<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\EmployeePortfolio;

/**
 * Class EmployeePortfolioTransformer.
 *
 * @package namespace App\Transformers;
 */
class EmployeePortfolioTransformer extends TransformerAbstract
{
    /**
     * Transform the EmployeePortfolio entity.
     *
     * @param \App\Models\EmployeePortfolio $model
     *
     * @return array
     */
    public function transform(EmployeePortfolio $model)
    {
        return [
            'id'          => (int)$model->id,
            'name'        => $model->name,
            'description' => $model->description,
            'url'         => $model->url,
            'start_date'  => $model->start_date->format('Y-m-d H:i:s'),
            'end_date'    => $model->end_date->format('Y-m-d H:i:s'),
            'experience'  => $model->workExperience
        ];
    }
}
