<?php

namespace App\Http\Controllers\Api\Secured;
use App\Criterias\PreEmploymentChecklist\WithEmployee;
use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Employee\EmployeeChecklistRepository;
use App\Validators\EmployeeChecklistValidator;
use App\Transformers\EmployeeChecklistTransformer;
use App\Repositories\PreEmploymentChecklist\PreEmploymentChecklistRepository;
use App\Validators\PreEmploymentChecklistValidator;
use App\Transformers\PreEmploymentChecklistTransformer;
use Dingo\Api\Http\Request;
use App\Models\EmployeeChecklist;
use App\Models\PreEmploymentChecklist;
use App\Models\Asset;

class EmployeeChecklistController extends BaseController
{
    CONST LIMIT = 100; // set limit for pages
    CONST TYPE  = 4;   // asset type for checklist

    public function __construct(
        EmployeeChecklistRepository $repository,
        EmployeeChecklistValidator $validator,
        EmployeeChecklistTransformer $transformer,
        PreEmploymentChecklistRepository $prepository,
        PreEmploymentChecklistValidator $pvalidator,
        PreEmploymentChecklistTransformer $ptransformer)
    {
        $this->repository   = $repository;
        $this->validator    = $validator;
        $this->transformer  = $transformer;
        $this->prepository  = $prepository;
        $this->pvalidator   = $pvalidator;
        $this->ptransformer = $ptransformer;  
        $this->asset        = new Asset; 
    }

    /**
     * Show employee checklist
     *
     * @return Collection
     */
    public function index(Request $request)
    {
        return $this->response->paginator($this->prepository->paginate($this::LIMIT), $this->ptransformer);
    } 

    /**
     * DELETE a resource specified by id
     *
     * @param int $id
     * @return noContent
     */
    public function destroy($id)
    {
        // check if asset exists
        if ($this->asset->where(['assetable_id' => $id, 'type' => $this::TYPE])->exists()) {
            // remove asset thru soft delete
            $this->asset->first()->delete();
        }
        
        // call base api func
        return parent::destroy($id);
    }
}