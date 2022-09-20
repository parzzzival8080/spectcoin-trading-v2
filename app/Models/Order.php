<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //

    protected $fillable = ['client_id', 'coin_pair_id', 'role',
    'client_wallet_id', 'delegate_type', 'unit_price',
    'state', 'number_of_order', 'total_commission', 'final_price', 'volume', 'turnover','commission_time', 'last_modified'];
// 
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function clientWallet()
    {
        return $this->belongsTo(ClientWallet::class, 'client_wallet_id', 'id');
    }

    public function coinPair()
    {
        return $this->belongsTo(CoinPair::class, 'coin_pair_id', 'id');
    }
}
