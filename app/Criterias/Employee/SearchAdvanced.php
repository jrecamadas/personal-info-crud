<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchAdvanced implements CriteriaInterface
{
    private $nameArr, $projectArr, $skillArr, $locationArr, $clientArr;
    private $nameCount, $locationCount, $nameCard, $locationCard;

    public function __construct($nameArr, $projectArr, $skillArr, $locationArr, $clientArr)
    {
        $this->nameArr = $nameArr;
        $this->projectArr = $projectArr;
        $this->skillArr = $skillArr;
        $this->locationArr = $locationArr;
        $this->clientArr = $clientArr;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        //This creates the number of '?' to match the number of name values
        $this->nameCount = count($this->nameArr);
        if($this->nameArr[0] != ''){
            $this->nameCard = '?';
            for($ctr = 1; $ctr < $this->nameCount; $ctr++){
                $this->nameCard .= ',?';
            }
        }

        //This creates the number of '?' to match the number of location values
        $this->locationCount = count($this->locationArr);
        if($this->locationArr[0] != ''){
            $this->locationCard = '?';
            for($ctr = 1; $ctr < $this->locationCount; $ctr++){
                $this->locationCard .= ',?';
            }
        }

        //Retrieves the data combination specified in the advance search (NAME AND PROJECT AND SKILL AND LOCATION), 
        //also added the unassigned to get employees without a project
        return $model->where(function ($query) {
            $query->when($this->nameArr[0] != '', function($q){
                        return $q->WhereRaw('REPLACE(CONCAT_WS("", `employees`.`last_name`, `employees`.`first_name`, `employees`.`middle_name`, `employees`.`ext`), " ", "") IN ('. $this->nameCard .')', $this->nameArr);
                    })
                    ->where(function($q){
                        return $q->when($this->projectArr[0] != '', function($q){
                            return $q->WhereIn('client_projects.project_name', $this->projectArr)
                                    ->when(in_array('Unassigned',$this->projectArr) !== false, function($q){
                                        return $q->orWhere('client_projects.project_name','=',NULL);
                                    });
                        });
                    })
                    ->where(function($q){
                        return $q->when($this->clientArr[0] != '', function($q){
                            return $q->WhereIn('clients.company', $this->clientArr)
                                    ->when(in_array('Unassigned',$this->clientArr) !== false, function($q){
                                        return $q->orWhere('clients.company','=',NULL);
                                    });
                        });
                    })
                    ->when($this->skillArr[0] != '', function($q){
                        return $q->WhereIn('skills.name',$this->skillArr);
                    })
                    ->when($this->locationArr[0] != '', function($q){
                        return $q->WhereRaw('REPLACE(CONCAT_WS("", `employee_locations`.`city`, `employee_locations`.`country`), " ", "") IN ('. $this->locationCard .')', $this->locationArr);
                    });
            
        });
        
    }
}
