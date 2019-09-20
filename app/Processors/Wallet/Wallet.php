<?php

namespace App\Processors\Wallet;

use DB;
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

    public function index($listener){
        $wallet = WalletModel::latest()->paginate(15);
        return $listener->showWalletListing($wallet);
    }


    public function show($listener, $walletUuid)
    {
        //$id =  auth()->user()->id;
         if(!$walletUuid){
             return $listener->walletDoesNotExistsError();
         }
         try {
            //$wallet = WalletModel::where('user_id','=',$id)->firstorfail();
            $wallet = WalletModel::where('uuid', $walletUuid)->firstorfail();
         } catch(ModelNotFoundException $e) {
             return $listener->walletDoesNotExistsError();
         }
         return $listener->showWallet($wallet);
    }

    public function update($listener, $walletUuid, array $inputs){
         $validator = $this->validator->on('update')->with($inputs);
         if ($validator->fails()) {
             throw new UpdateFailed('Could not update wallet', $validator->errors());
         }
         try {
             $wallet = WalletModel::where('uuid', $walletUuid)->firstorfail();
         } catch (ModelNotFoundException $e) {
             return $listener->walletDoesNotExistsError();
         }

         $wallet->update([
             'amount' => $inputs['amount'],
             'type' => $inputs['type'],
             'is_active' => $inputs['is_active'],
         ]);

         return setApiResponse('success', 'updated', 'wallet');
     }

    // user wallet

    public function showUserWallet($listener){
        
        $id =  auth()->user()->id;

        try {
            $wallet = WalletModel::where('user_id', $id)->firstorfail();
        } catch(ModelNotFoundException $e) {
            return $listener->walletDoesNotExistsError();
        }

        return $listener->showWallet($wallet);
    }

    public function updateUserWallet($listener, array $inputs)
    {
        $validator = $this->validator->on('update')->with($inputs);
        if ($validator->fails()) {
            throw new UpdateFailed('Could not update wallet', $validator->errors());
        }

        $id =  auth()->user()->id;
        
        try {
            $wallet = WalletModel::where('user_id', $id)->firstorfail();
        } catch(ModelNotFoundException $e) {
            return $listener->walletDoesNotExistsError();
        }

        $wallet->update([
            'amount' => $inputs['amount'],
            'type' => $inputs['type'],
            'is_active' => $inputs['is_active'],
        ]);

        return setApiResponse('success','updated','wallet');
    }
}