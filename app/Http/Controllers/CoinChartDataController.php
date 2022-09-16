<?php

namespace App\Http\Controllers;

use App\Models\CoinChartData;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CoinChartDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $date = Carbon::now()->subDay(1);
        $dateCandleClose = $date."23:59:50" ; //21:48:09
        $data = CoinChartData::where('coin_pair_id', $request->input('coin_pair_id'))->orderBy('date', 'ASC')->get();
        $dailyHigh = CoinChartData::where('coin_pair_id', $request->input('coin_pair_id'))->whereBetween($date."00:00:00", $dateCandleClose)->max('close')    ->first();
        $dailyLow = CoinChartData::where('coin_pair_id', $request->input('coin_pair_id')->whereBetween($date."00:00:00", $dateCandleClose))->min('close')->first();
        $dailyHighVol = CoinChartData::where('coin_pair_id', $request->input('coin_pair_id'))->whereBetween($date."00:00:00", $dateCandleClose)->max('volume')->first();
        $dailyLowVol = CoinChartData::where('coin_pair_id', $request->input('coin_pair_id'))->whereBetween($date."00:00:00", $dateCandleClose)->min('volume')->first();
        $getPreviousPrice = CoinChartData::where('coin_pair_id', $request->input('coin_pair_id'))->whereBetween($date."00:00:00", $dateCandleClose)->orderBy('date', 'DESC')->first();

        $current_price = CoinChartData::where('coin_pair_id', $request->input('coin_pair_id'))->orderBy('date', 'DESC')->first();
        $getPercentage = ($getPreviousPrice->close - $current_price->close) / $getPreviousPrice->close;
        
        
        

        return response()->json([
            'chart' => $data,
            'daily_high' =>$dailyHigh,
            'daily_low' => $dailyLow,
            'daily_high_vol' => $dailyHighVol,
            'daily_low_vol' => $dailyLowVol,
            'current_price' => $current_price,
            'percentage' => $getPercentage
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
    public function store(Request $request)
    {
        //
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
}
