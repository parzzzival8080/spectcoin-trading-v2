<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Future extends Model
{
    //
    protected $fillable = ['client_id', 'coin_pair_id', 'client_wallet_future_id', 'opening_price', 'leverage', 'estimated_force_parity', 'margin', 'open_interest', 'current_price', 'manual_closing_allowed',
    'reached_take_profit_difference','reached_stop_loss_difference', 'income', 'status', 'rate_of_return'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function coinPair()
    {
        return $this->belongsTo(CoinPair::class, 'coin_pair_id', 'id');
    }

    public function clientWalletFuture()
    {
        return $this->belongsTo(ClientWalletFuture::class, 'client_wallet_future_id', 'id');
    }
}
