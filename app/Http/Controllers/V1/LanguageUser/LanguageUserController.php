<?php

namespace App\Http\Controllers\V1\LanguageUser;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Transformers\LanguageUserTransformer;
use Dingo\Api\Exception\StoreResourceFailedException;
use App\Processors\LanguageUser\LanguageUser as LanguageUserProcessor;

class LanguageUserController extends Controller
{
    public function index(LanguageUserProcessor $processor){
        return $processor->index($this);
    }

    public function getWithoutPagination(LanguageUserProcessor $processor){
        return $processor->getWithoutPagination($this);
    }

    public function search(LanguageUserProcessor $processor){
        return $processor->search($this, Input::all());
    }

    public function show($uuid,LanguageUserProcessor $processor){
        return $processor->show($this,$uuid);
    }
    public function store(LanguageUserProcessor $processor){
        return $processor->store($this, Input::all());
    }

    public function update(LanguageUserProcessor $processor,$LanguageUserUuid)
    {
        return $processor->update($this, $LanguageUserUuid, Input::all());
    }

    public function destroy(LanguageUserProcessor $processor, $LanguageUserUuid)
    {
        return $processor->delete($this, $LanguageUserUuid);
    }

    public function showLanguageUserListing($LanguageUser)
    {
        return $this->response->paginator($LanguageUser, new LanguageUserTransformer);
    }

    public function showLanguageUserListingNoPaginate($LanguageUser)
    {
        return $this->response->collection($LanguageUser, new LanguageUserTransformer);
    }

    public function showLanguageUser($LanguageUser)
    {
        return $this->response->item($LanguageUser, new LanguageUserTransformer);
    }

    public function LanguageUserDoesNotExistsError()
    {
        return $this->response->errorNotFound("LanguageUser does not exists");
    }
    // public function TypeDoesNotExistsError()
    // {
    //     return $this->response->errorNotFound("Type does not exists");
    // }


}
