<?php

namespace App\Processors\Wallet;

use Carbon\Carbon;
use App\Models\Wallet as WalletModel;

use App\Processors\Processor;
use GuzzleHttp\Client as GuzzleClient;
use App\Validators\Wallet as Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Dingo\Api\Exception\StoreResourceFailedException as StoreFailed;
use Dingo\Api\Exception\DeleteResourceFailedException as DeleteFailed;
use Dingo\Api\Exception\ResourceException as ResourceFailed;
use Dingo\Api\Exception\UpdateResourceFailedException as UpdateFailed;

class Wallet extends Processor 
{
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function show($listener)
    {
        $id = auth()->user()->id;
        try {
            $Wallet = WalletModel::where('user_id', $id)->firstorfail();
        } catch (ModelNotFoundException $e) {
            return $listener->walletDoesNotExistError();
        }
        return $listener->showWallet($Wallet);
    }

    public function store($listener, array $inputs)
    {
        /*if (!checkUserAccess('management'))
            return setApiResponse('error', 'access');*/
        $validator = $this->validator->on('create')->with($inputs);
        if ($validator->fails()) {
            return $listener->validationFailed($validator->getMessageBag());
        }

        $userID = auth()->user()->id;
        WalletModel::create([
            'amount' => $inputs['amount'],
            'user_id' => $userID,
        ]);

        return setApiResponse('success', 'created', 'Wallet created');

    }

    public function update($listener, $id, array $inputs){
        $validator = $this->validator->on('topup')->with($inputs);
        if ($validator->fails()) {
            throw new UpdateFailed('Amount required', $validator->errors());
        }
        try {
            $wallet = WalletModel::where('user_id', $id)->firstorfail();
        } catch (ModelNotFoundException $e) {
            return $listener->walletDoesNotExistsError();
        }

        $wallet->update([
            'amount' => $inputs['amount'],
        ]);

        return setApiResponse('success', 'update successful', 'wallet');
    }
}