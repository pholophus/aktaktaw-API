<?php

namespace App\Http\Transformers;

use App\Concerns\Formatter;
use App\Models\User as UserModel;
use App\Models\Language as LanguageModel;
use League\Fractal\TransformerAbstract;

class ProfileTransformer extends TransformerAbstract
{
    use Formatter;

    public function transform(UserModel $user)
    {
        return [
            'user_id' => $user->uuid ?? '',
            'name' => $user->profile->name ?? '',
            'email' => $user->email ?? '',
            'phone_no' => $user->profile->phone_no ?? '',
            'languages' => $this->languages($user) ?? '',
            'avatar_file_path' => $user->profile->avatar_file_path ?? '',
            'resume_file_path' => $user->profile->resume_file_path ?? '',
            'expertise' => $this->expertise($user) ?? '',
            'user_status' => $user->user_status ?? '',
            'translator_status' => $user->translator_status ?? '',
            'is_new' => $user->is_new ?? '',
            'wallet' => $this->wallet($user) ?? '',
            'roles' => $this->roles($user) ?? '',
            'booking' => $this->booking($user) ?? '',
            'created_at' => $user->profile->created_at->format('c'),
            'updated_at' => $user->profile->created_at->format('c'),
        ];
    }

    public function wallet(UserModel $user)
    {
        $type = '';

        if($user->wallet->type == 0){
            $type = 'prepaid';
        }else{
            $type = 'postpaid';
        }

        $item[] = [
            'id' => $user->wallet->uuid ?? '',
            'amount' => $user->wallet->amount ?? '',
            'type' => $type,
            'status' => $user->wallet->status ?? '',
        ];
        return $item;
    }

    public function languages(UserModel $user)
    {
        $type = '';

        if($user->languages()->value('language_type') == 0){
            $type = 'native';
        }else if($user->languages()->value('language_type') == 1){
            $type = 'speaking';
        }else{
            $type = 'other';
        }

        $item[] = [
            'id' => $user->languages()->value('uuid') ?? '',
            'name' => $user->languages()->value('language_name') ?? '',
            'type' => $type,
        ];

        return $item;
    }

    public function expertise(UserModel $user)
    {
        $item[] = [
            'id' => $user->expertises()->value('uuid') ?? '',
            'name' => $user->expertises()->value('expertise_name') ?? '',
            'status' => $user->expertises()->value('expertise_status') ?? '',
            //'language_code' => $user->expertises()->where('language_type','=',1)->value('language_code') ?? '',
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

    public function booking(UserModel $user)
    {
        $type = '';

        if($user->bookings()->value('type') == 0){
            $type = 'pre-booking';
        }else{
            $type = 'on-demand';
        }

        $item[] = [
            'id' => $user->bookings()->value('uuid') ?? '',
            'type' => $type,
        ];

        return $item;
    }
}

