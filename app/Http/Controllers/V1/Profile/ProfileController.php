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

    public function showProfile(ProfileProcessor $processor){
        return $processor->show($this);
    }

    public function updateProfile(ProfileProcessor $processor){
        return $processor->update($this,Input::all());
    }

    public function updatePassword(ProfileProcessor $processor){
        return $processor->updatePassword($this,Input::all());
    }

    public function showUserProfile($user){
        return $this->response->item($user, new ProfileTransformer);
    }
   
    public function validationFailed($errors)
    {
        throw new StoreResourceFailedException('Error authenticating account', $errors);
    }

    public function accountDoesNotExistsError()
    {
        return $this->response->errorNotFound("Account does not exists");
    }

    public function ExpertiseDoesNotExistsError()
    {
        return $this->response->errorNotFound("Expertise does not exists");
    }

    public function LanguageDoesNotExistsError()
    {
        return $this->response->errorNotFound("Language does not exists");
    }

}
