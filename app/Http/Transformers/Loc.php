<?php

namespace App\Http\Transformers;

use App\Concerns\Formatter;
use App\Models\Loc as LocModel;
use League\Fractal\TransformerAbstract;

class LocTransformer extends TransformerAbstract
{
    use Formatter;

    public function transform(LocModel $Loc)
    {
        return [
            'value' => $Loc->value,
            'quantity' => $Loc->quantity,
            'fromWhere' => $Loc->fromWhere,
            'investment' => $Loc->investment,
            'created_at' => $Loc->created_at->format('c'),
            'updated_at' => $Loc->created_at->format('c'),
        ];
    }

}
