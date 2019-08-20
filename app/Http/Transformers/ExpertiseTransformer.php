<?php

namespace App\Http\Transformers;

use App\Concerns\Formatter;
use App\Models\Expertise as ExpertiseModel;
use League\Fractal\TransformerAbstract;

class ExpertiseTransformer extends TransformerAbstract
{
    use Formatter;

    public function transform(ExpertiseModel $expertise)
    {
        return [
            'id' => $expertise->uuid,
            'name' => $expertise->name,
            'created_at' => $expertise->created_at->format('c'),
            'updated_at' => $expertise->created_at->format('c'),
        ];
    }
}
