<?php

namespace App\Http\Transformers;

use App\Concerns\Formatter;
use App\Models\Wallet as WalletModel;
use App\Models\User as UserModel;
use League\Fractal\TransformerAbstract;

class WalletTransformer extends TransformerAbstract
{
    use Formatter;

    public function transform(UserModel $user)
    {
        $wallet = $user->wallet;
        return [
            'user_id' => $user->uuid,
            'amount' => $wallet->amount,
            'type' => $wallet->type,
            'status' => $wallet->status,
            'created_at' => $wallet->created_at->format('c'),
            'updated_at' => $wallet->created_at->format('c'),
        ];
    }
}