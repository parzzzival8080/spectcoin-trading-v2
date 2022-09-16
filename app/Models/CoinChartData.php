<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class CoinChartData extends Model
{
    //
    // use UsesUuid;

    protected $fillable = ['coin_pair_id','date', 'open', 'high', 'low', 'close', 'volume', 'increase_in_value', 'price_range_from', 'price_range_to', ''];   

    public function coin()
    {
        return $this->belongsTo(Coin::class, 'coin_id', 'id');
    }

    public function coinChartData()
    {
        return $this->belongsTo(CoinChartData::class, 'coin_pair_id', 'id');
    }
}
