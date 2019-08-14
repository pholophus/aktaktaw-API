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
    public function index(WalletProcessor $processor){
        return $processor->index($this);
    }

    // public function show($uuid,WalletProcessor $processor){
    //     return $processor->show($this,$uuid);
    // }

    // public function update($uuid, WalletProcessor $processor){
    //     return $processor->update($this, $uuid, Input::all());
    // }

    public function showUserWallet(WalletProcessor $processor){
        return $processor->showUserWallet($this);
    }

    public function updateUserWallet(WalletProcessor $processor){
        return $processor->updateUserWallet($this,Input::all());
    }

    public function showWallet($wallet)
    {
        return $this->response->item($wallet, new WalletTransformer);
    }
    public function showWalletListing($wallet)
    {
        return $this->response->paginator($wallet, new WalletTransformer);
    }

    public function walletDoesNotExistsError()
    {
        return $this->response->errorNotFound("wallet does not exists");
    }
}
