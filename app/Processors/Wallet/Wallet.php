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

    // public function index($listener){
    //     // if(!checkUserAccess('management'))
    //     //     return setApiResponse('error','access');

    //     $wallet = WalletModel::latest()->paginate(15);
    //     return $listener->showWalletListing($wallet);
    // }


    // public function show($listener,$walletUuid)
    // {

    //     if(!$walletUuid){
    //         return $listener->walletDoesNotExistsError();
    //     }
    //     try {
    //         $wallet = WalletModel::where('uuid',$walletUuid)->firstorfail();
    //     } catch(ModelNotFoundException $e) {
    //         return $listener->walletDoesNotExistsError();
    //     }
    //     return $listener->showWallet($wallet);
    // }

    // public function update($listener, $walletUuid, array $inputs){
    //     $validator = $this->validator->on('update')->with($inputs);
    //     if ($validator->fails()) {
    //         throw new UpdateFailed('Could not update wallet', $validator->errors());
    //     }
    //     try {
    //         $wallet = WalletModel::where('uuid', $walletUuid)->firstorfail();
    //     } catch (ModelNotFoundException $e) {
    //         return $listener->walletDoesNotExistsError();
    //     }

    //     $wallet->update([
    //         'amount' => $inputs['amount'],
    //     ]);

    //     return setApiResponse('success', 'updated', 'wallet');
    // }

    // user wallet

    public function showUserWallet($listener){

        //->profile()->wallet()

        return $listener->showWallet(auth()->user());
    }

    public function updateUserWallet($listener, array $inputs)
    {
        //use validator when retrieving input
        $validator = $this->validator->on('update')->with($inputs);
        if ($validator->fails()) {
            throw new UpdateFailed('Could not update wallet', $validator->errors());
        }
        //->profile()->wallet()
        $wallet = auth()->user()->wallet();
        $wallet->update([
            'amount' =>  $inputs['amount'],
        ]);

        return setApiResponse('success','updated','wallet');
    }
}