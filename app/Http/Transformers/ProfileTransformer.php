<?php

namespace App\Http\Transformers;

use App\Concerns\Formatter;
use App\Models\Profile as ProfileModel;
use League\Fractal\TransformerAbstract;

class ProfileTransformer extends TransformerAbstract
{
    use Formatter;

    public function transform(ProfileModel $profile)
    {
        return [
            'id' => $profile->uuid,
            'first_name' => $profile->first_name,
            'last_name' => $profile->last_name,
            'phone_no' => $profile->phone_no ?? '',
            'avatar_file_path' => $profile->avatar_file_path ?? '',
            'resume_file_path' => $profile->resume_file_path ?? '',
            'account_balance' => $profile->account_balance,
            'created_at' => $profile->created_at->format('c'),
            'updated_at' => $profile->created_at->format('c'),
        ];
    }
}
