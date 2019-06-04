<?php

namespace App\Traits;

use Dingo\Api\Http\Request;
use App\Http\SecuredRequest;
use \Prettus\Validator\Contracts\ValidatorInterface;

/**
 * CleanPostData Trait
 *
 * @package App\Traits
 * @author Ismael Cristal Jr <icristal@fullscale.io>
 */
trait CleanPostData
{
    /**
     * Handle POST request for the resource, saving new data
     *
     * @param Dingo\Api\Http\Request $request
     * @return Resource Item
     */
    public function store(Request $request)
    {
        $r = new SecuredRequest($request, $this->validator);

        $r->setValidationRule(ValidatorInterface::RULE_CREATE);

        return parent::store($r);
    }

    /**
     * PUT|PATCH update a resource
     *
     * @param Dingo\Api\Http\Request $request
     * @param int $id
     * @return Resource Item
     */
    public function update(Request $request, $id)
    {
        $r = new SecuredRequest($request, $this->validator);

        $r->setValidationRule(ValidatorInterface::RULE_UPDATE);

        return parent::update($r, $id);
    }
}
