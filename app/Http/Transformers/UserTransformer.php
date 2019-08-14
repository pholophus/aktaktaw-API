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
            'profiles' =>  $this->profile($user) ?? '',
            'roles' => $this->roles($user) ?? '',
            // 'branches' => $this->branches($user) ?? '',
            // 'groups' => $this->groups($user) ?? '',
            // 'is_new' => isBoolean($user->is_new),
            'created_at' => $user->created_at->format('c'),
            'updated_at' => $user->created_at->format('c'),
        ];
    }

    
    public function profile(UserModel $user)
    {
        $item[] = [
            'first_name' => $user->profile->first_name ?? '',
            'last_name' => $user->profile->last_name ?? '',
            'phone_no' => $user->profile->phone_no ?? '',
            'avatar_file_path' => $user->profile->avatar_file_path ?? '',
            'resume_file_path' => $user->profile->resume_file_path ?? '',
            'wallet' => $this->wallet($user) ?? '',
        ];
        return $item;
    }

    public function wallet(UserModel $user)
    {
        $item[] = [
            'id' => $user->wallet->uuid,
            'amount' => $user->wallet->amount,
        ];
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
