<?php

namespace App\Criterias\ReportTemplate;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchByReportType implements CriteriaInterface
{
	protected $request;

	public function __construct($request)
	{
		$this->request = $request;
	}

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('type', 'like', '%'.$this->request->type.'%');
    }
}
