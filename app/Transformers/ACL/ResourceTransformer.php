<?php

namespace App\Transformers\ACL;

use League\Fractal\TransformerAbstract;
use App\Models\ACL\Resource;

class ResourceTransformer extends TransformerAbstract
{
    public function transform(Resource $resource)
    {
        return [
            'id'           => (int)$resource->id,
            'name'         => $resource->name,
            'display_name' => $resource->display_name,
            'description'  => $resource->description
        ];
    }
}
