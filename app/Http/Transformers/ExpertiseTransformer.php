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
            'fee_rate' => $this->fee($expertise),
            'is_active' => $expertise->is_active == 1 ? true : false,
            'created_at' => $expertise->created_at->format('c'),
            'updated_at' => $expertise->created_at->format('c'),
        ];
    }

    public function fee(ExpertiseModel $expertise)
    {
        $expertises = $expertise->fees()->get();
        $item = [];
        foreach($expertises as $expertise)
        {
           
        $item[] = [
            
            'id' => $expertise->uuid ?? '',
            'name' => $expertise->fee_name ?? '',
            'duration' => $expertise->fee_duration ?? '',
            'rate' => $expertise->fee_rate ?? '',
            'status' => $expertise->fee_status ?? '',
            //'language_code' => $expertise->expertises()->where('language_type','=',1)->value('language_code') ?? '',
        ];
        }


        return $item;
    }
}
