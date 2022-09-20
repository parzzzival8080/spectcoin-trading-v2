<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientWalletFuture extends Model
{
    //

    protected $fillable = [
        'client_id', 'coin_id', 'wallet_balance'
    ];

    public function coinWallet()
    {
        return $this->belongsTo(ClientWallet::class, 'client_wallet_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, );
    }

    public function coin()
    {
        return $this->belongsTo(Coin::class, 'coin_id', 'id');
    }

}
