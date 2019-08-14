<?php

namespace App\Http\Transformers;

use App\Concerns\Formatter;
use League\Fractal\TransformerAbstract;
use App\Models\Type as TypeModel;
class TypeTransformer extends TransformerAbstract
{
    use Formatter;

    public function transform(TypeModel $types)
    {
         return[
            'id'=> $types->uuid,
            'name'=> $types->name,
            'category'=> $types->category,
            'created_at'=> $types->created_at->format('c'),
            'updated_at'=> $types->updated_at->format('c')
        ];
    }



}
