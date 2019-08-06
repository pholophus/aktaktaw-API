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
            'email' => $user->email,
            'user_status_id' => $user->user_status_id ?? '',
            'translator_status_id' => $user->translator_status_id ?? '',
            'social_google_id' => $user->social_google_id ?? '',
            'social_facebook_id' => $user->social_facebook_id ?? '',
            'profiles' => $user->profile,
            //'roles' => $this->roles($user) ?? '',
            // 'branches' => $this->branches($user) ?? '',
            // 'groups' => $this->groups($user) ?? '',
            // 'is_new' => isBoolean($user->is_new),
            'created_at' => $user->created_at->format('c'),
            'updated_at' => $user->created_at->format('c'),
        ];
    }

    
    // public function groups(UserModel $user)
    // {
    //     $groups = $user->groups;
    //     $item = [];
    //     foreach ($groups as $group) {
    //         $item[] = [
    //             'id' => $group->uuid,
    //             'name' => $group->name,
    //             'slug' => $group->slug
    //         ];
    //     }
    //     return $item;
    // }
    // public function roles(UserModel $user)
    // {
    //     $items = [];
    //     $roles = $user->roles()->get();
    //     foreach ($roles as $role) {
    //         array_push($items, [
    //             'id' => $role->uuid,
    //             'slug' => $role->slug,
    //             'name' => $role->name
    //         ]);
    //     }
    //     return $items;
    // }
}
