<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class CoinPair extends Model
{
    //
    // use UsesUuid;
    
    protected $fillable = [
        'coin_id', 'coin_pair_id', 'partition' ,'open_for_trade_status', 'pair_type',
        'currency_transaction_status', 'contract_transaction_status', 'automatic_collection_status',
        'mainstream_currency_status', 'withdrawal_status', 'contract_delivery_cycle', 'queue_number'
    ,'current_price', 'increase_in_value', 'minimum_withdrawal_amount', 'withdrawal_fee', 'account_balance_limit', 'minimum_sell', 'volume', 'turnover'
    ];

    public function coin()
    {
        return $this->belongsTo(Coin::class, 'coin_id', 'id');
    }

    public function coinPair()

    {
        return $this->belongsTo(Coin::class, 'coin_pair_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
