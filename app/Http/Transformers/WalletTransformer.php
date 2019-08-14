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
            'type' => $wallet->type,
            'status' => $wallet->status,
            'created_at' => $wallet->created_at->format('c'),
            'updated_at' => $wallet->created_at->format('c'),
        ];
    }
}