<?php

namespace App\Processors\Profile;

use Carbon\Carbon;
use App\Models\User as UserModel;
use App\Models\Profile as ProfileModel;
use App\Processors\Processor;
use GuzzleHttp\Client as GuzzleClient;
use App\Validators\Profile as Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

use Dingo\Api\Exception\StoreResourceFailedException as StoreFailed;
use Dingo\Api\Exception\DeleteResourceFailedException as DeleteFailed;
use Dingo\Api\Exception\ResourceException as ResourceFailed;
use Dingo\Api\Exception\UpdateResourceFailedException as UpdateFailed;

class Profile extends Processor
{

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function show($listener){
        // $userId= auth()->user()->id;

        // $profile = ProfileModel::where('user_id',$userId)->firstorfail();

        return $listener->showUserProfile(auth()->user());
    }

    public function update($listener, array $inputs)
    {
        //use validator when retrieving input
        $validator = $this->validator->on('update')->with($inputs);
        if ($validator->fails()) {
            throw new UpdateFailed('Could not update user', $validator->errors());
        }
        $profile = auth()->user()->profile();
        $profile->update([
            'name' => $inputs['name'],
            'phone_no' => $inputs['phone_no'],
            'avatar_file_path' => $inputs['image'],
            'resume_file_path' => $inputs['resume'],
        ]);

        $user = auth()->user();

        $user->update([
            'translator_status_id' => $inputs['translator_status'],
            'is_new' => $inputs['is_new']
        ]);

        $id = auth()->user()->id;

        $user->languages()->where('user_id',$id)->sync([
            'language_id' => $inputs['languages'],
        ]);

        $user->expertises()->where('user_id',$id)->sync([
            'expertise_id' => $inputs['expertise'],
        ]);

        return setApiResponse('success','updated','user profile');
    }

    public function updatePassword($listener, array $inputs){
        $validator = $this->validator->on('Password')->with($inputs);
        if ($validator->fails()) {
            throw new UpdateFailed('Could not update user', $validator->errors());
        }

        $user = auth()->user();

        $password = $inputs['password'];
        $user->update([
            'password' => bcrypt($password),
        ]);
        
        return setApiResponse('success','updated','user password');
    }

}

