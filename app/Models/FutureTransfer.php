<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FutureTransfer extends Model
{
    //

    protected $fillable = ['client_id','coin_id', 'client_wallet_id', 'client_wallet_future_id', 'draw_type', 'state', 'transfer_amount', 
                            'transfer_time', 'review_time', 'auditor', 'notes'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function coin()
    {
        return $this->belongsTo(Coin::class, 'coin_id', 'id');
    }

    public function clientWalletFuture()
    {
        return $this->belongsTo(ClientWalletFuture::class, 'client_wallet_future_id', 'id');
    }
}
