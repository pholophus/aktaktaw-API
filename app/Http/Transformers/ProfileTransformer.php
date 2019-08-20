<?php

namespace App\Http\Transformers;

use App\Concerns\Formatter;
use App\Models\User as UserModel;
use League\Fractal\TransformerAbstract;

class ProfileTransformer extends TransformerAbstract
{
    use Formatter;

    public function transform(UserModel $user)
    {
        return [
            'user_id' => $user->uuid ?? '',
            'first_name' => $user->profile->first_name ?? '',
            'last_name' => $user->profile->last_name ?? '',
            'phone_no' => $user->profile->phone_no ?? '',
            'avatar_file_path' => $user->profile->avatar_file_path ?? '',
            'resume_file_path' => $user->profile->resume_file_path ?? '',
            'roles' => $this->roles($user) ?? '',
           // 'wallet' => $this->wallet($user) ?? '',
            'created_at' => $user->profile->created_at->format('c'),
            'updated_at' => $user->profile->created_at->format('c'),
        ];
    }

    // public function wallet(UserModel $user)
    // {
    //     $item[] = [
    //         'id' => $user->wallet->uuid,
    //         'amount' => $user->wallet->amount,
    //     ];
    //     return $item;
    // }

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

