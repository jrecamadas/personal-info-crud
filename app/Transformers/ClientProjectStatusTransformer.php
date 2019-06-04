<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ClientProjectStatus;

class ClientProjectStatusTransformer extends TransformerAbstract
{
    public function transform(ClientProjectStatus $statuses)
    {
        return [
            'id'          => (int)$statuses->id,
            'name'        => $statuses->name,
            'description' => $statuses->description
        ];
    }
}
