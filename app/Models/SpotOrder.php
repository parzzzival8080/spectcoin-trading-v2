<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpotOrder extends Model
{
    
    protected $fillable = ['client_id', 
    'coin_pair_id', 
    'client_wallet_id', 
    'role', 
     'delegate_type', 
     'state', 
     'number_of_order',
      'order_per_unit', 
    'total_commission', 
    'final_price', 
    'volume', 
    'turnover', 
    'commission_time', 
    'last_modified'];

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
