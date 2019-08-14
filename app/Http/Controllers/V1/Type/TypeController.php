<?php

namespace App\Http\Controllers\V1\Type;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Transformers\TypeTransformer;
use Dingo\Api\Exception\StoreResourceFailedException;
use App\Processors\Type\Type as TypeProcessor;

class TypeController extends Controller
{
    public function index(TypeProcessor $processor){
        return $processor->index($this);
    }

    public function show($uuid,TypeProcessor $processor){
        return $processor->show($this,$uuid);
    }

    public function store(TypeProcessor $processor){
        return $processor->store($this, Input::all());
    }

    public function update(TypeProcessor $processor,$TypeUuid)
    {
        return $processor->update($this, $TypeUuid, Input::all());
    }

    public function destroy(TypeProcessor $processor, $TypeUuid)
    {
        return $processor->delete($this, $TypeUuid);
    }

    public function showType($Type)
    {
        return $this->response->item($Type, new TypeTransformer);
    }

    public function showTypeListing($type)
    {
        return $this->response->paginator($type, new TypeTransformer);
    }

    public function TypeDoesNotExistsError()
    {
        return $this->response->errorNotFound("Type does not exists");
    }

}
