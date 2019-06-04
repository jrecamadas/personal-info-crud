<?php

namespace App\Criterias\ClientProject;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class Search implements CriteriaInterface
{
    private $term;

    public function __construct($term)
    {
        $this->term = trim($term);
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $search = array('\\','%','_','*',"'",'"');
        $replace = array('\\\\\\','\%','\_','\*',"\'",'\"');
        $this->term = str_replace($search, $replace, $this->term);

        $model =  $model->where(function($query){
            return $query->where('project_name', 'LIKE', '%' . $this->term . '%')
                ->orWhere('project_description', 'LIKE', '%' . $this->term . '%')
                ->orWhere('project_url', 'LIKE', '%' . $this->term . '%');
        });

        return $model;
    }
}
