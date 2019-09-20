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
            'user' => $this->user($wallet),
            'amount' => $wallet->amount,
            'type' => $wallet->type == 0 ? 'prepaid' : 'postpaid',
            'is_active' => $wallet->is_active == 1,
            'created_at' => $wallet->created_at->format('c'),
            'updated_at' => $wallet->created_at->format('c'),
        ];
    }

    public function user(WalletModel $wallet)
    {
        $user = $wallet->user;
        
        return [
            'user_id' => $user->uuid,
            'name' => $user->name,
            'email' => $user->email,
        ];
    }
}