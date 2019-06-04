<?php

namespace App\Http;

use Dingo\Api\Http\Request;

class SecuredRequest extends Request
{
    private $internalRequest = null;
    private $validator = null;
    private $validationRule = '';

    public function __construct(Request $request, $validator)
    {
        $this->internalRequest = $request;
        $this->validator = $validator;
    }

    public function setValidationRule($value)
    {
        $this->validationRule = $value;
    }

    public function all($keys = NULL)
    {
        if (!empty($this->validator)) {
            $fields = array_keys($this->validator->getRules($this->validationRule));
            return $this->internalRequest->only($fields);
        } else {
            return $this->internalRequest->all($keys);
        }
    }
}
