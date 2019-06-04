<?php

namespace App\Criterias\ClientFeedback;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchByFilter implements CriteriaInterface
{
    private $key;
    private $val;

    public function __construct($key, $val)
    {
        $this->key = $key;
        $this->val = $val;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        if ($this->key == "status") {
            if ($this->val == "1") {  // Get Awaiting Confirmation
                return $model->whereRaw('recurring_type != 5 
                                        && is_confirmation_needed = 1 
                                        && is_confirmed = 0');
            } else if ($this->val == "2") {  // Get Confirmed Survey
                return $model->whereRaw('recurring_type != 5 
                                        && is_confirmation_needed = 1 
                                        && is_confirmed = 1');
            } else if ($this->val == "3") {  // Get Awaiting Response
                return $model->whereIn('id', function ($query) {
                    $query->select('ss.project_survey_id')
                         ->from('survey_sent as ss')
                         ->whereRaw('ss.date_replied = ss.date_sent')
                         ->groupBy('ss.project_survey_id');
                });
            } else if ($this->val == '4') { // Get Responded
                return $model->whereIn('id', function ($query) {
                    $query->select('ss.project_survey_id')
                         ->from('survey_sent as ss')
                         ->whereRaw('ss.date_replied <> ss.date_sent')
                         ->groupBy('ss.project_survey_id');
                });
            } else if ($this->val == '5') { // Not yet Sent
                return $model->whereNotIn('id', function ($query) {
                    $query->select('ss.project_survey_id')
                         ->from('survey_sent as ss');
                });
            } else {
                return $model;
            }
        } elseif ($this->key == "recurring_type" || $this->key == "project_id") { // Get By Project or Occurrence
            return $model->where($this->key, $this->val);
        } else {
            return $model;
        }
    }
}
