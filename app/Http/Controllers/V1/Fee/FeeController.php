<?php
namespace App\Http\Controllers\V1\Fee;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Collection;
use App\Http\Transformers\FeeTransformer;
use Dingo\Api\Exception\StoreResourceFailedException;
use App\Processors\Fee\Fee as FeeProcessor;

class FeeController extends Controller
{
    public function index(FeeProcessor $processor){
        return $processor->index($this);
    }

    public function show($uuid,FeeProcessor $processor){
        return $processor->show($this,$uuid);
    }
    public function store(FeeProcessor $processor){
        return $processor->store($this, Input::all());
    }

    public function update(FeeProcessor $processor,$FeeUuid)
    {
        return $processor->update($this, $FeeUuid, Input::all());
    }

    public function destroy(FeeProcessor $processor, $FeeUuid)
    {
        return $processor->delete($this, $FeeUuid);
    }

    public function showFeeListing($Fee)
    {
        return $this->response->paginator($Fee, new FeeTransformer);
    }

    public function showFee($Fee)
    {
        return $this->response->item($Fee, new FeeTransformer);
    }

    public function validationFailed($errors)
    {
        throw new StoreResourceFailedException('Create Fee failed ,Missing Parameters', $errors);
    }

    public function FeeDoesNotExistsError()
    {
        return $this->response->errorNotFound("Fee does not exists");
    }

}
