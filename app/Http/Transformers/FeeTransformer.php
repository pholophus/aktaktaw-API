<?php

namespace App\Http\Transformers;

use App\Concerns\Formatter;
use App\Models\Fee as FeeModel;
use League\Fractal\TransformerAbstract;

class FeeTransformer extends TransformerAbstract
{
    use Formatter;

    public function transform(FeeModel $Fee)
    {
        return [
            'fee_id' => $Fee->uuid,
            'fee_name' => $Fee->fee_name,
            'fee_duration' => $Fee->fee_duration,
            'fee_rate' => $Fee->fee_rate,
            'fee_status' => $Fee->fee_status,
            'created_at' => $Fee->created_at->format('c'),
            'updated_at' => $Fee->created_at->format('c'),
        ];
    }

}
