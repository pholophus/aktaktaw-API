<?php

namespace App\Http\Transformers;

use App\Concerns\Formatter;
use League\Fractal\TransformerAbstract;
use App\Models\Role as RoleModel;
class RoleTransformer extends TransformerAbstract
{
    use Formatter;

    public function transform(RoleModel $roles)
    {
         return[
            'id'=> $roles->uuid,
            'display_name'=> $roles->name_display,
            'name'=> $roles->name,
            'slug'=> $roles->slug,
            'created_at'=> $roles->created_at->format('c'),
            'updated_at'=> $roles->updated_at->format('c')
        ];
    }



}
