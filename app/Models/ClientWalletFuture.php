<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientWalletFuture extends Model
{
    //

    protected $fillable = [
        'client_wallet_id', 'coin_pair_id', 'wallet_balance'
    ];

    public function coinWallet()
    {
        return $this->belongsTo(ClientWallet::class, 'client_wallet_id', 'id');
    }

    public function coinPair()
    {
        return $this->belongsTo(CoinPair::class, 'coin_pair_id', 'id');
    }

}
