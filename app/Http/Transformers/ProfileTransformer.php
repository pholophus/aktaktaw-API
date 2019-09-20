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
            'type' => $type ?? '',
            'status' => $user->wallet->status ?? '',
        ];
        return $item;
    }

    public function languages(UserModel $user)
    {
        //dd($user->userlanguages());
        $languages = $user->languages()->get();
        $item = [];
        foreach($languages as $language)
        {
            $type = '';
            if($language->pivot->language_type == 0){
                $type = 'native';
            }else if($language->pivot->language_type == 1){
                $type = 'speaking';
            }else{
                $type = 'other';
            }

            $item[] = [
                'id' => $language->uuid ?? '',
                'name' => $language->name ?? '',
                'type' => $type,
                'flag_url' => $language->flag_url,
            ];
        }

        return $item;
    }

    public function expertise(UserModel $user)
    {
        $expertises = $user->expertises()->get();
        $item = [];
        foreach($expertises as $expertise)
        {
            $item[] = [
                'id' => $expertise->uuid ?? '',
                'name' => $expertise->expertise_name ?? '',
                'status' => $expertise->expertise_status ?? '',
                    //'language_code' => $user->expertises()->where('language_type','=',1)->value('language_code') ?? '',
            ];
        }

        return $item;
    }
    
    public function roles(UserModel $user)
    {
        $roles = $user->roles()->get();
        $item = [];
        foreach($roles as $role)
        {
            $item[] = [
                'id' => $role->uuid ?? '',
                'name' => $role->name ?? '',
            ];
        }

        return $item;
    }

    public function booking(UserModel $user)
    {
        
        $bookings = $user->bookings()->get();
        $item = [];
        $type = '';

        if ($user->bookings()->count() == 0)
        {
            return [];
        }
        else
        {
            foreach($bookings as $booking)
            {
                $type = $booking->booking_type == 0 ?'pre-booking' : 'on-demand';

                $item[] = [
                    'id' => $booking->uuid ?? '',
                    'type' => $type,
                ];
            }
        }
            return $item;
    }
}


