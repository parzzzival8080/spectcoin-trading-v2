<?php

namespace App\Http\Controllers;

use App\Http\Requests\FutureRequest\IndexFutureRequest;
use App\Http\Requests\FutureRequest\StoreFutureRequest;
use App\Models\Client;
use App\Models\ClientWalletFuture;
use App\Models\Coin;
use App\Models\CoinChartData;
use App\Models\CoinPair;
use App\Models\Future;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use TechTailor\BinanceApi\BinanceAPI;

class FutureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexFutureRequest $request)
    {
        //
        $auth = Auth::user();

        if($auth->role == 'ADMINISTRATOR')
        {
            $future = Future::with('client', 'coinPair')->get();
        }
        elseif($auth->role == 'CLIENT')
        {
            $client = Client::where('user_id', $auth->id)->first();
            $future = Future::where('client_id', $client->id)->orderBy('id', 'DESC')->first();
        }

        return response()->json([
            'future' => $future 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFutureRequest $request)
    {
        
        $auth = Auth::user();
        $client = Client::where('user_id', $auth->id)->first();
        $clientWalletFuture = ClientWalletFuture::where('client_id', $client->id)->first();
        //
        $open_interest = 0;
        $rate_of_return = 0;

        /** Get Parity by dividing current_price / leverage */
        $coin = Coin::where('name', $request->input('name'))->first();
        $coinpair = CoinPair::where('coin_id', $coin->id)->first();
        // dd($request->input('delegate_type'));

        // dd($coinpair->pair_type);

        if($coinpair->pair_type == 'MAIN')
        {
            $binance = new BinanceAPI();
            $coinPair = $request->input('name').'USDT';
            $btcPrice = $binance->getTicker($coinPair);

           

            if($request->input('delegate_type') == 'BUY')
            {
                $parity = $btcPrice['lastPrice'] - ($btcPrice['lastPrice'] / $request->input('leverage'));

                $open_interest = $request->input('margin') * $request->input('leverage');

                /** Get Stop loss difference by margin * leverage  */
                $stop_loss_difference = (($request->input('margin') / $btcPrice['lastPrice']) * $request->input('leverage') * $btcPrice['lastPrice'] - $open_interest) + $request->input('margin');

                /** Reach take profit  difference*/
                $reached_take_profit_difference = ($request->input('margin') / $btcPrice['lastPrice']) * $request->input('leverage') * $btcPrice['lastPrice'];

                /** Get income by stop loss difference - margin */
                $income = $stop_loss_difference - $request->input('margin');

                /** Get rate of return by (current price - old price / old price) * 100  * leverage*/
                $rate_of_return = (($btcPrice['lastPrice'] - $btcPrice['lastPrice']) / ($btcPrice['lastPrice']) * $request->input('leverage'));

                $future = Future::create(array_merge(
                    [
                        'client_id' => $client->id,
                        'coin_pair_id' => $coinpair->id,
                        'client_wallet_future_id' => $clientWalletFuture->id, 
                        'estimated_force_parity' => $parity,
                        'open_interest' => $open_interest,
                        'opening_price' => $btcPrice['lastPrice'] ,
                        'current_price' => $btcPrice['lastPrice'] ,
                        'margin' => $request->input('margin'),
                        'leverage' => $request->input('leverage'),
                        'manual_closing_allowed' => 'NO',
                        'reached_stop_loss_difference' => $stop_loss_difference,
                        'reached_take_profit_difference' => $reached_take_profit_difference,
                        'income' => $income,
                        'status' => 'LOCKED',
                        'rate_of_return' => $rate_of_return
                    ], 
                ));

                return response()->json(
                    [
                        'future' => $future
                    ]
                );
            }
        }

        



        // $current_price = CoinChartData::where('coin_pair_id', $coinpair->id)->orderBy('date', 'DESC')->first();

        // $parity = $current_price->close - ($current_price->close / $request->input('leverage'));

        // $open_interest = $request->input('margin') * $request->input('leverage');

        // /** Get Stop loss difference by margin * leverage  */
        // $stop_loss_difference = (($request->input('margin') / $current_price->close) * $request->input('leverage') * $current_price->close - $open_interest) + $request->input('margin');
        
        // $reached_take_profit_difference = ($request->input('margin') / $current_price->close) * $request->input('leverage') * $current_price->close;
        // /** Get income by stop loss difference - margin */
        // $income = $stop_loss_difference - $request->input('margin');

        // /** Get rate of return by (current price - old price / old price) * 100  * leverage*/
        // $rate_of_return = $current_price->close - $current_price->close / $current_price->close * $request->input('leverage');

        // $future = Future::create(array_merge(
        //     [
        //         'estimated_force_parity' => $parity,
        //         'open_interest' => $open_interest,
        //         'current_price' => $current_price->close,
        //         'manual_closing_allowed' => 'NO',
        //         'reached_stop_loss_difference' => $stop_loss_difference,
        //         'reached_take_profit_difference' => $reached_take_profit_difference,
        //         'income' => $income,
        //         'rate_of_return' => $rate_of_return
        //     ]
        // ));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateTable(Request $request)
    {
        $futures = Future::all();

        foreach($futures as $future)
        {
            $price = CoinChartData::where('coin_pair_id', $future->coin_pair_id)->orderBy('date', 'DESC')->first();
            $current_price = $price->close;
            /** Get rate of return by (current price - old price / old price) * 100  * leverage*/
            $rate_of_return = ((($current_price - $future->opening_price) / $future->opening_price) *100) * 10;
            $stop_loss_difference = (($future->margin / $future->open_price) * $future->leverage * $future->current_price - $future->open_interest) + $future->margin;
            $reached_take_profit_difference = ($future->margin / $future->open_price) * $future->leverage * $future->current_price;
            $future->update(
                ['current_price' => $current_price,
                'stop_loss_difference' => $stop_loss_difference,
                'income' => $stop_loss_difference - $future->margin,
                'reached_take_profit_difference' => $reached_take_profit_difference,
                 'rate_of_return' => $rate_of_return]
                 
            );
        }
    }

    public function margin()
    {
        $auth = Auth::user();

        if($auth->role == 'ADMINISTRATOR')
        {
            $future = Future::with('client', 'coin')->get();
        }
        elseif($auth->role == 'CLIENT')
        {
            $client = Client::where('user_id', $auth->id)->first();
            $future = Future::where('client_id', $client->id)->orderBy('id', 'DESC')->first();
        }

        return response()->json([
            'margin' => $future 
        ]);
    }
}
