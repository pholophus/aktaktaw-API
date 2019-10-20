<?php

namespace App\Http\Transformers;

use App\Concerns\Formatter;
use App\Models\Investor as InvestorModel;
use League\Fractal\TransformerAbstract;

class InvestorTransformer extends TransformerAbstract
{
    use Formatter;

    public function transform(InvestorModel $Investor)
    {
        return [
            'value' => $Investor->value,
            'quantity' => $Investor->quantity,
            'from' => $Investor->fromWhere,
            'created_at' => $Investor->created_at->format('c'),
            'updated_at' => $Investor->created_at->format('c'),
        ];
    }

}
