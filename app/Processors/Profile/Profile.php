<?php

namespace App\Processors\Profile;

use Carbon\Carbon;
use App\Models\User as UserModel;

use App\Processors\Processor;
use GuzzleHttp\Client as GuzzleClient;
use App\Validators\User as Validator;
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

    public function index($listener){
        return $listener->showUser(auth()->user());
    }

    public function update($listener, array $inputs)
    {
        //use validator when retrieving input
        $validator = $this->validator->on('update')->with($inputs);
        if ($validator->fails()) {
            throw new UpdateFailed('Could not update user', $validator->errors());
        }
        $user = auth()->user()->profile();
        $user->update([
            'first_name' =>  $inputs['first_name'] ,
            'last_name' =>  $inputs['last_name'] ,
            'phone_no' => cleanPhoneNumber($inputs['phone_no']),
            'resume_file_path' => $inputs['resume_file_path'] ,
        ]);

        if(isset($inputs['avatar_file_path'])){
            $user->image_url = $inputs['avatar_file_path'];    
            $user->save();
        }
        if(isset($inputs['resume_file_path'])){
            $user->image_url = $inputs['resume_file_path'];    
            $user->save();
        }

        return setApiResponse('success','updated','user profile');
    }

}

