<?php

namespace App\Http\Controllers;

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
        // $auth = Auth::user();
        // if($auth->role == )
        // {

        // }
        if($request->input('delegate_type') == 'BUY')
        {

        }
        elseif($request->input('delegate_type' == 'SELL'))
        {

        }

        $price = 
        $response = Http::get('https://binance.com/api/v3/depth?limit=10&symbol=BTCUSDT')->json();
        $binance = new BinanceAPI();
        $btc = 'BTCUSDT';
        $result = $binance->getOrderBook($btc);
    

        return response()->json(['result' => $response]);
    }
}
