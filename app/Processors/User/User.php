<?php

namespace App\Processors\User;

use Carbon\Carbon;
use Request;
use App\Processors\Processor;
use App\Models\User as UserModel;

use App\Validators\User as Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Dingo\Api\Exception\StoreResourceFailedException as StoreFailed;
use Dingo\Api\Exception\DeleteResourceFailedException as DeleteFailed;
use Dingo\Api\Exception\ResourceException as ResourceFailed;
use Dingo\Api\Exception\UpdateResourceFailedException as UpdateFailed;

class UserProcessor extends Processor
{
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }


     public function index($listener)
    {
        try {
            $users =  UserModel::paginate(15);
        } catch(ModelNotFoundException $e) {
            return $listener->usersDoesNotExistsError();
        }
        return $listener->showUserListing($users);
    }

    public function show($listener, $userUuid)
    {

        try {
            $user = UserModel::where('uuid',$userUuid)->firstorfail();
        } catch(ModelNotFoundException $e) {
            return $listener->usersDoesNotExistsError();
        }

        return $listener->showUser($user);
    }

    public function store($listener, array $inputs)
    {
        //use validator when retrieving input
        $validator = $this->validator->on('create')->with($inputs);
        if ($validator->fails()) {
            throw new StoreFailed('Could not create new user.', $validator->errors());
        }


        $user = UserModel::create([
            'title' =>  $inputs['title'] ,
            'description' =>  $inputs['description'],
        ]);

        return setApiResponse('success','created','user');
    }

    public function update($listener, $userUuid, array $inputs)
    {
        //use validator when retrieving input
        $validator = $this->validator->on('update')->with($inputs);
        if ($validator->fails()) {
            throw new UpdateFailed('Could not update user.', $validator->errors());
        }
        try {
            $user = UserModel::where('uuid',$userUuid)->firstorfail();
        } catch(ModelNotFoundException $e) {
            return $listener->userDoesNotExistsError();
        }


        $update = $user->update([
            'title' =>  $inputs['title'] ,
            'description' =>  $inputs['description'],
            'start' =>  $inputs['start'],
            'end' =>  $inputs['end'],
            'assignor_id' => auth()->user()->id
        ]);

        return setApiResponse('success','updated','user');
    }

    public function delete($listener,$userUuid)
    {
        if(!$userUuid){
            throw new DeleteFailed('Could not delete user.');
        }

        try {
            $user = UserModel::where('uuid',$userUuid)->firstorfail();
        } catch(ModelNotFoundException $e) {
            return $listener->userDoesNotExistsError();
        }
        $user->delete();


        return setApiResponse('success','deleted','user');
    }
}
