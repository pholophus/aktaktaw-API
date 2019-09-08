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
            'role_id'=> $roles->uuid,
            'role_name'=> $roles->name,
            'display_name'=> $roles->name_display,
            'created_at'=> $roles->created_at->format('c'),
            'updated_at'=> $roles->updated_at->format('c')
        ];
    }



}
