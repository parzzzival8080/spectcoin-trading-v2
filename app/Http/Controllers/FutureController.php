<?php

namespace App\Http\Controllers;

use App\Http\Requests\FutureRequest\IndexFutureRequest;
use App\Http\Requests\FutureRequest\StoreFutureRequest;
use App\Models\CoinChartData;
use App\Models\Future;
use Illuminate\Http\Request;

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
        //
        $open_interest = 0;
        $rate_of_return = 0;

        /** Get Parity by dividing current_price / leverage */
        $current_price = CoinChartData::where('coin_pair_id', $request->input('coin_pair_id'))->orderBy('date', 'DESC')->first();
        $parity = $current_price->close - ($current_price->close / $request->input('leverage'));

        $open_interest = $request->input('margin') * $request->input('leverage');

        /** Get Stop loss difference by margin * leverage  */
        $stop_loss_difference = (($request->input('margin') / $current_price->close) * $request->input('leverage') * $current_price->close - $open_interest) + $request->input('margin');
        
        $reached_take_profit_difference = ($request->input('margin') / $current_price->close) * $request->input('leverage') * $current_price->close;
        /** Get income by stop loss difference - margin */
        $income = $stop_loss_difference - $request->input('margin');

        /** Get rate of return by (current price - old price / old price) * 100  * leverage*/
        $rate_of_return = $current_price->close - $current_price->close / $current_price->close * $request->input('leverage');

        $future = Future::create(array_merge(
            [
                'estimated_force_parity' => $parity,
                'open_interest' => $open_interest,
                'current_price' => $current_price->close,
                'manual_closing_allowed' => 'NO',
                'reached_stop_loss_difference' => $stop_loss_difference,
                'reached_take_profit_difference' => $reached_take_profit_difference,
                'income' => $income,
                'rate_of_return' => $rate_of_return
            ]
        ));
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
}
