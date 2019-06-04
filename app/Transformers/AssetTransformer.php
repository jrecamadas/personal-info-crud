<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Asset;

class AssetTransformer extends TransformerAbstract
{
    public function transform(Asset $asset)
    {
        return [
            'id'   => (int)$asset->id,
            'path' => $asset->path,
            'type' => (int)$asset->type
        ];
    }
}
