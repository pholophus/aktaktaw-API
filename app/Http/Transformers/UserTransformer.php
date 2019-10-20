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
            'user_id' => $user->uuid,
            'name' => $user->profile->name,
            'email' => $user->email ?? '',
            'user_status' => $user->user_status ?? '',
            'translator_status' => $user->translator_status ?? '',
            'is_new' => $user->is_new ?? '',
            'role' => $this->roles($user) ?? '',
            'profile' =>  $this->profile($user) ?? '',
            'wallet' => $this->wallet($user),
            'social_google_id' => $this->google($user) ?? '',
            'social_facebook_id' => $this->facebook($user) ?? '',
            'country' => $user->country ?? '',
            'created_at' => $user->created_at->format('c'),
            'updated_at' => $user->created_at->format('c'),
        ];
    }

    
    public function profile(UserModel $user)
    {
        $item[] = [
            'id' => $user->uuid ?? '',
            'name' => $user->profile->name ?? '',
            'email' => $user->email ?? '',
            'phone_no' => $user->profile->phone_no ?? '',
        ];
        return $item;
    }

    public function wallet(UserModel $user)
    {
        $type = $user->wallet->type == 0 ? 'prepaid' : 'postpaid';

        return [
            'id' => $user->wallet->uuid,
            'amount' => $user->wallet->amount,
            'type' => $type,
            'is_active' => $user->wallet->is_active,
        ];
    }

    public function google(UserModel $user)
    {
        $item[] = [
            'id' => $user->uuid ?? '',
            'name' => $user->profile->name ?? '',
            'token' => $user->social_google_id ?? '',
        ];
        return $item;
    }

    public function facebook(UserModel $user)
    {
        $item[] = [
            'id' => $user->uuid ?? '',
            'name' => $user->profile->name ?? '',
            'token' => $user->social_facebook_id ?? '',
        ];
        return $item;
    }

    public function roles(UserModel $user)
    {
        $item[] = [
            'id' => $user->roles()->value('uuid') ?? '',
            'name' => $user->roles()->value('name') ?? '',
        ];
        return $item;
    }
}
