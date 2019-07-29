<?php

namespace App\Processors\User;

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
        $user = auth()->user();
        $user->update([
            'name' =>  $inputs['name'] ,
            'nickname' =>  $inputs['nickname'],
            'phone_no' => cleanPhoneNumber($inputs['phone_no']),
        ]);

        if(isset($inputs['image_url'])){
            $user->image_url = $inputs['image_url'];
            $user->save();
        }

        if(isset($inputs['password'])){
            $user->password = bcrypt($inputs['password']);
            $user->save();
        }

        return setApiResponse('success','updated','user profile');
    }

}

