<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use App\Models\CoinChartData;
use App\Models\CoinPair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use TechTailor\BinanceApi\BinanceAPI;

class BinanceAPIController extends Controller
{
    //
    public function topTenList()
    {
        // dd('working');
        $binance = new BinanceAPI();
        $btc = 'BTCUSDT';
        $eth = 'ETHUSDT';
        $xrp = 'XRPUSDT';
        $cardano = 'ADAUSDT';
        $sol = 'SOLUSDT';
        $doge = 'DOGEUSDT';
        $polkadot = 'DOTUSDT';
        $shib = 'SHIBUSDT';
        $galx = 'GALUSDT';
        $btcPrice = $binance->getTicker($btc);
        $ethPrice = $binance->getTicker($eth);
        $xrpPrice = $binance->getTicker($xrp);
        $adaPrice = $binance->getTicker($cardano);
        $solPrice = $binance->getTicker($sol);
        $dogePrice = $binance->getTicker($doge);
        $polPrice = $binance->getTicker($polkadot);
        $shibPrice = $binance->getTicker($shib);
        $galxPrice = $binance->getTicker($galx);

        //daily
        // $date = date('Y-m-d');
        // weekly
        //  $monday_current_week =  date('Y-m-d', $monday->getTimestamp());
        // $sunday_current_week = date('Y-m-d', $sunday->getTimestamp());
        //monthly
        //$start_date = date("Y-m-01", strtotime("this month"));
        //$end_date = date("Y-m-t", strtotime("this month"));


        return response()->json(
            [
                'btc' => $btcPrice, 
                'eth' => $ethPrice,
                'xrp' => $xrpPrice,
                'cardano' => $adaPrice,
                'sol' => $solPrice,
                'doge' => $dogePrice,
                'polkadot' => $polPrice,
                'shib' => $shibPrice,
                'galx' => $galxPrice,
            ]
        );
    }

    public function getOrder(Request $request)
    {

        $response = Http::get('https://binance.com/api/v3/depth?limit=5&symbol=BTCUSDT')->json();
        $binance = new BinanceAPI();
        $btc = 'BTCUSDT';
        $btcPrice = $binance->getTicker($btc);
        // dd($response);
    

        return response()->json([
            'result' => $response,
            'price' => $btcPrice
    ]);
    }

    public function BTCCHART(Request $request)
    {
        $coin = Coin::where('name', 'BTC')->first();
        $coinpair = CoinPair::where('coin_id', $coin->id)->first();
        $chartData = CoinChartData::where('coin_pair_id', $coinpair->id)->orderBy('date', 'DESC')->first();
        $binance = new BinanceAPI();
        $btc = $request->symbol.'USDT';
        $btcPrice = $binance->getTicker($btc);
        // dd($btcPrice);
        return response()->json(
            [
                'chart' => $btcPrice,
                'chartData' => $chartData
            ]
        );
        
    }
}
