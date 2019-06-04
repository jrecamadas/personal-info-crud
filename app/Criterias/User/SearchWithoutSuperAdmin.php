<?php

namespace App\Criterias\User;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchWithoutSuperAdmin implements CriteriaInterface
{
    private $term;

    public function apply($model, RepositoryInterface $repository)
    {
        $model =  $model->where(function($query){
            return $query->where('user_name', '<>',  'superadmin')
                ->orWhere('user_name', '=', NULL);
        });
        return $model;
    }
}
