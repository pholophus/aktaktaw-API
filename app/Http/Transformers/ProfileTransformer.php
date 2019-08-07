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
            'id' => $user->profile->id ?? '',
            'first_name' => $user->profile->first_name ?? '',
            'last_name' => $user->profile->last_name ?? '',
            'phone_no' => $user->profile->phone_no ?? '',
            'avatar_file_path' => $user->profile->avatar_file_path ?? '',
            'resume_file_path' => $user->profile->resume_file_path ?? '',
            'account_balance' => $user->profile->account_balance  ?? '',
            'created_at' => $user->profile->created_at->format('c'),
            'updated_at' => $user->profile->created_at->format('c'),
        ];

    }
}
