<?php
namespace App\Http\Controllers\V1\Investor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Collection;
use App\Http\Transformers\InvestorTransformer;
use Dingo\Api\Exception\StoreResourceFailedException;
use App\Processors\Investor\Investor as InvestorProcessor;

class InvestorController extends Controller
{
    public function index(InvestorProcessor $processor){
        return $processor->index($this);
    }

    public function show($uuid,InvestorProcessor $processor){
        return $processor->show($this,$uuid);
    }
    public function store(InvestorProcessor $processor){
        return $processor->store($this, Input::all());
    }

    public function update(InvestorProcessor $processor,$InvestorUuid)
    {
        return $processor->update($this, $InvestorUuid, Input::all());
    }

    public function destroy(InvestorProcessor $processor, $InvestorUuid)
    {
        return $processor->delete($this, $InvestorUuid);
    }

    public function showInvestorListing($Investor)
    {
        return $this->response->paginator($Investor, new InvestorTransformer);
    }

    public function showInvestor($Investor)
    {
        return $this->response->item($Investor, new InvestorTransformer);
    }

    public function validationFailed($errors)
    {
        throw new StoreResourceFailedException('Create Investor failed ,Missing Parameters', $errors);
    }

    public function InvestorDoesNotExistsError()
    {
        return $this->response->errorNotFound("Investor does not exists");
    }

}
