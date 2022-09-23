<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoinPair\IndexCoinPairRequest;
use App\Http\Requests\CoinPair\StoreCoinPairRequest;
use App\Http\Requests\CoinPair\UpdateCoinPairRequest;
use App\Models\Coin;
use App\Models\CoinChartData;
use App\Models\CoinPair;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CoinPairController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexCoinPairRequest $request)
    {
        //

        $pair_type = $request->input('pair_type');
        // if($pair_type == 'ALL')
        // {
        //     $coinpair = CoinPair::with('coin', 'coinPair')->get();
        // }
        // else{
        //     $coinpair = CoinPair::where('pair_type', $pair_type)->with('coin', 'coinPair')->get();
        // }

        
        // dd($pair_type);
        $coinpair = CoinPair::with('coin', 'coinPair')->get();

        return response()->json(
            [
                'coinpairs' => $coinpair
            ]
        );
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
    public function store(StoreCoinPairRequest $request)
    {
        //
        $coinpair = CoinPair::create($request->validated());

        return response()->json([
            '$coinpair' => $coinpair
        ]);
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
    public function update(UpdateCoinPairRequest $request, CoinPair $coinpair)
    {
        //
        $coinpair = Coinpair::where('id', $coinpair->id)->first();
        $coinpair->update($request->validated());

        return response()->json(
            [
                'coinpair' => $coinpair
            ]
        );
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

    public function latestCandle(Request $request)
    {
        $data = CoinChartData::where('coin_pair_id', $request->input('coin_pair_id'))->orderBy('id', 'DESC')->first();

        return response()->json(
            [
                'chart' => $data
            ]
        );
    }

    public function updateCandle(Request $request)
    {

        // dd($request->input('id'));
        $data = CoinChartData::where('id', $request->input('id'))->first();

        // dd($request->input('high'));
        // dd($data);
        $data->update(
            [
               'open' => $request->input('open'),
               'high' => $request->input('high') ,
               'low' => $request->input('low') ,
               'close' => $request->input('close') ,
               'volume'=> $request->input('volume') ,
            ]
        );

        return response()->json(
            ['chart' => $data]
        );
    }

    public function addChartData(Request $request)
    {
        $coin = Coin::where('name', $request->input('pair'))->first();
        $coinpair = CoinPair::where('coin_id', $coin->id)->first();
        $coindata = CoinChartData::where('coin_pair_id',  $coinpair->id)->orderBy('id', 'DESC')->first();
        $checkDateDuplication = CoinChartData::where('coin_pair_id',  $request->input('coin_pair_id'))->where('date', $request->input('date'))->orderBy('id', 'DESC')->first();

        if($checkDateDuplication == null)
        {
            $coin = Coin::where('name', $request->input('pair'))->first();
            
            // $increase_value = $forPercentage->close - $request->input('close') / $forPercentage->close;
            // dd($request->input('volume'));
            $data = CoinChartData::create(array_merge([
            'coin_pair_id' => $coinpair->id,
            'date' => $coindata->date + 60000,
            'open' => $request->input('open'),
            'high' => $request->input('high') ,
            'low' => $request->input('low') ,
            'close' => $request->input('close') ,
            'volume'=> $request->input('volume') ,
            'increase_in_value' =>$request->input('increase_in_value'),
            'price_range_from' => $request->input('price_range_from'),
            'price_range_to' =>  $request->input('price_range_to'),
        ]));
        }
        elseif($checkDateDuplication->date == $request->input('date'))
        {
            $coin = Coin::where('name', $request->input('pair'))->first();
            $coinpair = CoinPair::where('coin_id', $coin->id)->first();
            // $increase_value = $forPercentage->close - $request->input('close') / $forPercentage->close;
             $date = $checkDateDuplication->date + 60000;
            // dd($request->input('volume'));
            $data = CoinChartData::create(array_merge([
            'coin_pair_id' => $coinpair->id,
            'date' => $date,
            'open' => $request->input('open'),
            'high' => $request->input('high') ,
            'low' => $request->input('low') ,
            'close' => $request->input('close') ,
            'volume'=> $request->input('volume') ,
            'increase_in_value' =>$request->input('increase_in_value'),
            'price_range_from' => $request->input('price_range_from'),
            'price_range_to' =>  $request->input('price_range_to'),
        ]));
        }
            

        
        

        return response()->json(
            ['chart' => $data]
        );
    }

    public function btcChart(Request $request)
    {
        $date = Carbon::now()->subDay(1);
        $dateCandleClose = $date."23:59:50" ; //21:48:09
        $coin = Coin::where('name', $request->input('symbol'))->first();
        // dd($coin->id);
        $coinpair = CoinPair::where('coin_id', $coin->id)->first();
        $data = CoinChartData::where('coin_pair_id', $coinpair->id)->get();
        // $dailyHigh = CoinChartData::where('coin_pair_id', $request->input('coin_pair_id'))->whereBetween($date."00:00:00", $dateCandleClose)->max('close')->first();
        // $dailyLow = CoinChartData::where('coin_pair_id', $request->input('coin_pair_id')->whereBetween($date."00:00:00", $dateCandleClose))->min('close')->first();
        // $dailyHighVol = CoinChartData::where('coin_pair_id', $request->input('coin_pair_id'))->whereBetween($date."00:00:00", $dateCandleClose)->max('volume')->first();
        // $dailyLowVol = CoinChartData::where('coin_pair_id', $request->input('coin_pair_id'))->whereBetween($date."00:00:00", $dateCandleClose)->min('volume')->first();
        // $getPreviousPrice = CoinChartData::where('coin_pair_id', $request->input('coin_pair_id'))->whereBetween($date."00:00:00", $dateCandleClose)->orderBy('date', 'DESC')->first();

        // $current_price = CoinChartData::where('coin_pair_id', 1)->orderBy('date', 'DESC')->first();
        // $getPercentage = ($getPreviousPrice->close - $current_price->close) / $getPreviousPrice->close;
        
        
        return response()->json([
            'chart' => $data,
            // 'daily_high' =>$dailyHigh,
            // 'daily_low' => $dailyLow,
            // 'daily_high_vol' => $dailyHighVol,
            // 'daily_low_vol' => $dailyLowVol,
            // 'current_price' => $current_price,
            // 'percentage' => $getPercentage
        ]);
    }
}
