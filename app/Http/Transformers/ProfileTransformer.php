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
            'id' => $user->uuid ?? '',
            'first_name' => $user->profile->first_name ?? '',
            'last_name' => $user->profile->last_name ?? '',
            'phone_no' => $user->profile->phone_no ?? '',
            'avatar_file_path' => $user->profile->avatar_file_path ?? '',
            'resume_file_path' => $user->profile->resume_file_path ?? '',
            'wallet' => $this->wallet($user) ?? '',
            'created_at' => $user->profile->created_at->format('c'),
            'updated_at' => $user->profile->created_at->format('c'),
        ];
    }

    public function wallet(UserModel $user)
    {
        $item[] = [
            'id' => $user->wallet->uuid,
            'amount' => $user->wallet->amount,
        ];
        return $item;
    }
}

