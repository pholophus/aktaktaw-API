<?php

namespace App\Http\Controllers\V1\Wallet;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Transformers\WalletTransformer;
use Dingo\Api\Exception\StoreResourceFailedException;
use App\Processors\Wallet\Wallet as WalletProcessor;

class WalletController extends Controller
{
    public function show(WalletProcessor $processor){
        return $processor->show($this);
    }

    public function store(WalletProcessor $processor){
        return $processor->store($this,Input::all());
    }

    public function update($id, WalletProcessor $processor){
        return $processor->update($this, $id, Input::all());
    }

    public function showWallet($wallet)
    {
        return $this->response->item($wallet, new WalletTransformer);
    }

    public function walletDoesNotExistsError()
    {
        return $this->response->errorNotFound("wallet does not exists");
    }
}
