<?php

namespace App\Http\Transformers;

use App\Concerns\Formatter;
use App\Models\User as UserModel;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    use Formatter;

    public function transform(UserModel $user)
    {
        return [
            'id' => $user->uuid,
            'name' => $user->name,
            // 'nickname' => $user->nickname ?? '',
            'email' => $user->email,
            // 'phone_no' => $user->phone_no ?? '',
            // 'profile_image' => $user->image_url ?? '',
            'status' => $user->is_active,
            'roles' => $this->roles($user) ?? '',
            // 'branches' => $this->branches($user) ?? '',
            // 'groups' => $this->groups($user) ?? '',
            // 'is_new' => isBoolean($user->is_new),
            'created_at' => $user->created_at->format('c'),
            'updated_at' => $user->created_at->format('c'),
        ];
    }

    public function branches(UserModel $user)
    {
        $branches = $user->branches;
        $item = [];
        foreach ($branches as $branch) {
            $item[] = [
                'id' => $branch->uuid,
                'name' => $branch->name,
                'code' => $branch->code
            ];
        }
        return $item;
    }
    public function groups(UserModel $user)
    {
        $groups = $user->groups;
        $item = [];
        foreach ($groups as $group) {
            $item[] = [
                'id' => $group->uuid,
                'name' => $group->name,
                'slug' => $group->slug
            ];
        }
        return $item;
    }
    public function roles(UserModel $user)
    {
        $items = [];
        $roles = $user->roles()->get();
        foreach ($roles as $role) {
            array_push($items, [
                'id' => $role->uuid,
                'slug' => $role->slug,
                'name' => $role->name
            ]);
        }
        return $items;
    }
}
