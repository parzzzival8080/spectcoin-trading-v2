<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use App\Models\CoinChartData;
use App\Models\CoinPair;
use Illuminate\Http\Request;
use TechTailor\BinanceApi\BinanceAPI;

class ChartMonitorController extends Controller
{
    //

    public function chartMonitoringHighLow()
    {
        // dd('working');
        $coinpairs = CoinPair::all();

        foreach($coinpairs as $coinpair)
        {
            // dd('working');
            if($coinpair->pair_type == 'MAIN')
            {
                
                $coin = Coin::where('id', $coinpair->coin_id)->first();
                $binance = new BinanceAPI();
                $coinData = $binance->getTicker($coin->name.'USDT');
                $chartData = CoinChartData::where('coin_pair_id', $coinpair['id'])->orderBy('date', 'DESC')->first();
                
                if($coinData['lastPrice'] > $chartData->high)
                {
                    
                    $chartData->update([
                        'high' => $coinData['lastPrice'],
                        'close' => $coinData['lastPrice']
                    ]);
                }
                elseif($coinData['lastPrice'] < $chartData->low)
                {
                    // dd('working');
                    $chartData->update([
                        'low' => $coinData['lastPrice'],
                        'close' => $coinData['lastPrice']
                    ]);
                }
                else{
                    // dd('working');
                    $chartData->update([
                        'close' => $coinData['lastPrice']
                    ]);
                }
            }
        }
    }

    

    public function chartAddingCandle()
    {
        // dd('working');
        $coinpairs = CoinPair::all();

        foreach($coinpairs as $coinpair)
        {
            if($coinpair->pair_type == 'MAIN')
            {
                // dd('working');
                $coin = Coin::where('id', $coinpair->coin_id)->first();
                $binance = new BinanceAPI();
                $coinData = $binance->getTicker($coin->name.'USDT');
                $chartData = CoinChartData::where('coin_pair_id', $coinpair['id'])->orderBy('date', 'DESC')->first();

                $chartData = CoinChartData::create(
                    array_merge(
                        [   
                            'coin_pair_id' => $coinpair['id'],
                            'date' => $chartData->date + 60000,
                            'open' => $coinData['lastPrice'],
                            'high' => $coinData['lastPrice'],
                            'low' => $coinData['lastPrice'],
                            'close' => $coinData['lastPrice'],
                            'volume' => $coinData['volume'],
                            'increase_in_value' => $coinData['priceChangePercent'],
                            'price_range_from' => 0,
                            'price_range_to' => 0,
                        ]
                    )
                );
            }
        }
    }
}
