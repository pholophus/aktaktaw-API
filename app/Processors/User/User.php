<?php

namespace App\Processors\User;

use Carbon\Carbon;
use App\Models\User as UserModel;
use App\Models\Role as RoleModel;
use App\Models\Profile as ProfileModel;
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
            throw new UpdateFailed('Could not update user, wrong email format', $validator->errors());

        // check user if exist not deleted
        $chekuser = UserModel::where('email',$inputs['email'])->first();
        if($chekuser){
            return $listener->accountExistsError();
        }

        // $password = randomPassword();
        $password = 'secret';


        // if(is_array($inputs['role_id'])){
        //     $roles= RoleModel::whereIn('uuid',$inputs['role_id'])->get();
        //     if(!$roles){
        //         return $listener->roleNotExists();
        //     }
        // }else{
        //     $role= RoleModel::where('uuid',$inputs['role_id'])->first();
        //     if(!$role){
        //         return $listener->roleNotExists();
        //     }
        // }
        //if user ada dalam deleted model. then restore
        $chekdeleteduser = UserModel::where('email',$inputs['email'])->withTrashed()->first();
        //if true, restore the user and update
        if($chekdeleteduser)
            $chekdeleteduser->restore();


        $user = UserModel::updateorcreate([
            'email' => $inputs['email']
        ],[
            //'name' => $inputs['name'],
            'password'=>bcrypt($password)
        ]);

        $id= UserModel::where('email',$inputs['email'])->first()->id;
        $profile = ProfileModel::updateorcreate([
            'user_id' => $id,
        ]);


        // if(is_array($inputs['role_id'])){
        //     $user->assignRole($roles->pluck('name')->toArray());
        // }else{

        //     $user->assignRole($role->name);
        // }

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

        // $user->update([
        //     'name' =>  $inputs['name'] ,
        // ]);

        // if(isset($inputs['is_active'])){
        //     $user->is_active = $inputs['is_active'];
        //     $user->save();
        // }
        // if(isset($inputs['image_url'])){
        //     $user->image_url = $inputs['image_url'];
        //     $user->save();
        // }

        if(isset($inputs['password'])){
            $user->password = bcrypt($inputs['password']);
            $user->save();
        }

        // if(isset($inputs['role_id'])){
        //     if(is_array($inputs['role_id'])){
        //         $roles= RoleModel::whereIn('uuid',$inputs['role_id'])->get();
        //         if(!$roles){
        //             return $listener->roleNotExists();
        //         }
        //         $user->syncRoles($roles->pluck('name')->toArray());
        //     }else{
        //         $role= RoleModel::where('uuid',$inputs['role_id'])->first();
        //         if(!$role){
        //             return $listener->roleNotExists();
        //         }
        //         $user->syncRoles($role->name);
        //     }

        // }

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

        $user->delete();
        $profile->delete();

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


        return $listener->showUser($user);
    }
}

