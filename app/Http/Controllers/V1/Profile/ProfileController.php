<?php

namespace App\Http\Controllers\V1\Profile;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Transformers\ProfileTransformer;
use Dingo\Api\Exception\StoreResourceFailedException;
use App\Processors\Profile\Profile as ProfileProcessor;

class ProfileController extends Controller
{
   

    // public function index(ProfileProcessor $processor){
    //     return $processor->index($this);
    // }

    // public function search(UserProcessor $processor){
    //     return $processor->search($this, Input::all());
    // }

    public function showUserProfile($user){
        return $this->response->item($user, new ProfileTransformer);
    }

    // public function show($uuid,ProfileProcessor $processor){
    //     return $processor->show($this,$uuid);
    // }

    public function update( UserProcessor $processor,$userUuid)
    {
        return $processor->update($this, $userUuid, Input::all());
    }
   
    public function validationFailed($errors)
    {
        throw new StoreResourceFailedException('Error authenticating account', $errors);
    }

    public function accountDoesNotExistsError()
    {
        return $this->response->errorNotFound("Account does not exists");
    }

}
