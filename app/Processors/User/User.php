<?php

namespace App\Processors\User;

use Carbon\Carbon;
use App\Models\User as UserModel;
use App\Models\Role as RoleModel;
use App\Models\Profile as ProfileModel;
use App\Models\Wallet as WalletModel;
use App\Processors\Processor;
use GuzzleHttp\Client as GuzzleClient;
use App\Validators\User as Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Dingo\Api\Exception\StoreResourceFailedException as StoreFailed;
use Dingo\Api\Exception\DeleteResourceFailedException as DeleteFailed;
use Dingo\Api\Exception\ResourceException as ResourceFailed;
use Dingo\Api\Exception\UpdateResourceFailedException as UpdateFailed;

class User extends Processor
{

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function index($listener){
        // if(!checkUserAccess('management'))
        //     return setApiResponse('error','access');

        

        $user = UserModel::latest()->paginate(15);
        return $listener->showUserListing($user);
    }

    public function show($listener,$userUuid){
        // if(!checkUserAccess('management'))
        //     return setApiResponse('error','access');

        if(!$userUuid){
            return $listener->accountDoesNotExistsError();
        }
        try {
            $user = UserModel::where('uuid',$userUuid)->firstorfail();
        } catch(ModelNotFoundException $e) {
            return $listener->accountDoesNotExistsError();
        }
        return $listener->showUser($user);
    }

    public function store($listener, array $inputs)
    {
        // if(!checkUserAccess('management'))
        //     return setApiResponse('error','access');

        $validator = $this->validator->on('create')->with($inputs);
        if ($validator->fails()) {
            return $listener->validationFailed($validator->getMessageBag());
        }

        if(!validateEmail($inputs['email']))
            throw new UpdateFailed('Could not create user, wrong email format', $validator->errors());

        // check user if exist not deleted
        $user = UserModel::where('email',$inputs['email'])->first();
        if($user){
            return $listener->accountExistsError();
        }

        $validator = $this->validator->on('create')->with($inputs);
        if ($validator->fails()) {
            return $listener->validationFailed($validator->getMessageBag());
        }

        $user = UserModel::create([
            'email' => $inputs['email'],
            'password' => bcrypt($inputs['password']),
        ]);

        $profile = $user->profile();
        
        $profile->create([
            'name' => $inputs['name'],
        ]);

        $user->roles()->attach($inputs['role_id']);

       return setApiResponse('success','created','user');
    }

    public function update($listener, $userUuid, array $inputs)
    {
        // if(!checkUserAccess('management'))
        //     return setApiResponse('error','access');
        //use validator when retrieving input
        $validator = $this->validator->on('update')->with($inputs);
        if ($validator->fails()) {
            throw new UpdateFailed('Could not update user', $validator->errors());
        }
        try {
            $user = UserModel::where('uuid',$userUuid)->firstorfail();
        } catch(ModelNotFoundException $e) {
            return $listener->accountDoesNotExistsError();
        }

        $user->update([
            'user_status_id' => $inputs['user_status'],
            'translator_status_id' => $inputs['translator_status'],
        ]);
        $id = auth()->user()->id;

        $user->expertises()->where('user_id',$id)->sync([
            'expertise_id' => $inputs['expertise'],
        ]);

        return setApiResponse('success','updated','user');
    }

    public function delete($listener,$userUuid)
    {
        // if(!checkUserAccess('management'))
        //     return setApiResponse('error','access');

        if(!$userUuid){
            throw new DeleteFailed('Could not delete user');
        }

        try {
            $user = UserModel::where('uuid',$userUuid)->firstorfail();
        } catch(ModelNotFoundException $e) {
            return $listener->accountDoesNotExistsError();
        }

        $userId= UserModel::where('uuid',$userUuid)->first()->id;
        $profile= ProfileModel::where('user_id',$userId)->firstorfail();
        $wallet= WalletModel::where('user_id',$userId)->firstorfail();

        $user->delete();
        $profile->delete();
        $wallet->delete();


        return setApiResponse('success','deleted','user');
    }

    public function search($listener, array $inputs)
    {
        $validator =  $this->validator->on('search')->with($inputs);
        if($validator->fails())
        {
            throw new StoreFailed('No Results',$validator->errors());
        }
        $query = $inputs['query'];

        $user = UserModel::search($query)->paginate(20);

        //$user = UserModel::search($query)->get();

        return $listener->showUser($user);
    }
}

