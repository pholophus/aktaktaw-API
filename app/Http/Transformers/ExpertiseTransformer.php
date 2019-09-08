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
            'expertise_id' => $expertise->uuid,
            'expertise_name' => $expertise->expertise_name,
            'fee_rate' => $this->fee($expertise),
            'expertise_status' => $expertise->expertise_status,
            'created_at' => $expertise->created_at->format('c'),
            'updated_at' => $expertise->created_at->format('c'),
        ];
    }

    public function fee(ExpertiseModel $expertise)
    {
        $item[] = [
            'id' => $expertise->fees()->value('uuid') ?? '',
            'name' => $expertise->fees()->value('fee_name') ?? '',
            'duration' => $expertise->fees()->value('fee_duration') ?? '',
            'rate' => $expertise->fees()->value('fee_rate') ?? '',
            'status' => $expertise->fees()->value('fee_status') ?? '',
            //'language_code' => $expertise->expertises()->where('language_type','=',1)->value('language_code') ?? '',
        ];

        return $item;
    }
}
