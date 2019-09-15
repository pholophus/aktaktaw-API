<?php

namespace App\Http\Controllers\V1\Expertise;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Collection;
use App\Http\Transformers\ExpertiseTransformer;
use Dingo\Api\Exception\StoreResourceFailedException;
use App\Processors\Expertise\Expertise as ExpertiseProcessor;

class ExpertiseController extends Controller
{
    public function index(ExpertiseProcessor $processor){
        return $processor->index($this);
    }

    public function show($uuid,ExpertiseProcessor $processor){
        return $processor->show($this,$uuid);
    }
    public function store(ExpertiseProcessor $processor){
        return $processor->store($this, Input::all());
    }

    public function update(ExpertiseProcessor $processor,$expertiseUuid)
    {
        return $processor->update($this, $expertiseUuid, Input::all());
    }

    public function destroy(ExpertiseProcessor $processor, $expertiseUuid)
    {
        return $processor->delete($this, $expertiseUuid);
    }

    public function showExpertiseListing($expertise)
    {
        return $this->response->paginator($expertise, new ExpertiseTransformer);
    }

    public function showExpertise($expertise)
    {
        return $this->response->item($expertise, new ExpertiseTransformer);
    }

    public function validationFailed($errors)
    {
        throw new StoreResourceFailedException('Create expertise failed ,Missing Parameters', $errors);
    }

    public function expertiseDoesNotExistsError()
    {
        return $this->response->errorNotFound("expertise does not exists");
    }
    public function FeeDoesNotExistsError()
    {
        return $this->response->errorNotFound("fee does not exists");
    }

}
