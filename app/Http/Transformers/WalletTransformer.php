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
            'id' => $wallet->uuid,
            'amount' => $wallet->amount,
            'wallet type' => $wallet->wallet_type,
            'wallet status' => $wallet->wallet_status,
            'created_at' => $wallet->created_at->format('c'),
            'updated_at' => $wallet->created_at->format('c'),
        ];
    }
}