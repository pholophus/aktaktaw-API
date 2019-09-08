<?php

namespace App\Http\Transformers;

use App\Concerns\Formatter;
use App\Models\Wallet as WalletModel;
use League\Fractal\TransformerAbstract;

class WalletTransformer extends TransformerAbstract
{
    use Formatter;

    public function transform(WalletModel $wallet)
    {
        return [
            'wallet_id' => $wallet->uuid,
            'user_id' => $wallet->user->uuid,
            'amount' => $wallet->amount,
            'wallet_type' => $this->wallet($wallet),
            'wallet_status' => $wallet->status,
            'created_at' => $wallet->created_at->format('c'),
            'updated_at' => $wallet->created_at->format('c'),
        ];
    }

    public function wallet(WalletModel $wallet)
    {
        $type = '';

            if($wallet->type == 0){
                $type = 'prepaid';
            }else{
                $type = 'postpaid';
            }
        
            return $type;
    }
}