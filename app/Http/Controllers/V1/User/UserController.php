<?php

namespace App\Http\Controllers\V1\User;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Dingo\Api\Exception\StoreResourceFailedException;
use App\Processors\User\User as UserProcessor;
//use App\Processors\User\Profile as ProfileProcessor;
use App\Http\Transformers\UserTransformer;

class UserController extends Controller
{
    public function index(UserProcessor $processor){
        return $processor->index($this);
    }

    public function search(UserProcessor $processor){
        return $processor->search($this, Input::all());
    }

    public function show($uuid,UserProcessor $processor){
        return $processor->show($this,$uuid);
    }
    public function store(UserProcessor $processor){
        return $processor->store($this, Input::all());
    }

    public function update( UserProcessor $processor,$userUuid)
    {
        return $processor->update($this, $userUuid, Input::all());
    }

    public function destroy(UserProcessor $processor, $userUuid)
    {
        return $processor->delete($this, $userUuid);
    }

    //profile
    // public function showProfile(ProfileProcessor $processor){
    //     return $processor->index($this);
    // }

    // public function updateProfile(ProfileProcessor $processor){
    //     return $processor->update($this,Input::all());
    // }

    public function showUserListing($user)
    {
        return $this->response->paginator($user, new UserTransformer);
    }

    public function showUser($user)
    {
        return $this->response->item($user, new UserTransformer);
    }

    public function validationFailed($errors)
    {
        throw new StoreResourceFailedException('Create user failed ,Missing Parameters', $errors);
    }

    public function accountDoesNotExistsError()
    {
        return $this->response->errorNotFound("Account does not exists");
    }


    // public function branchNotExists()
    // {
    //     return $this->response->errorNotFound("Branch does not exists");
    // }

    public function accountExistsError()
    {
        return $this->response->errorNotFound("Account already exists, please use another email");
    }

    public function roleDoesNotExistsError()
    {
        return $this->response->errorNotFound("Role Does not Exist");
    }
}
