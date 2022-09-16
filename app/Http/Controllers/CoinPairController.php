<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoinPair\IndexCoinPairRequest;
use App\Http\Requests\CoinPair\StoreCoinPairRequest;
use App\Http\Requests\CoinPair\UpdateCoinPairRequest;
use App\Models\CoinChartData;
use App\Models\CoinPair;
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
        $data = CoinChartData::where('id', $request->input('id'))->first();

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
        $forPercentage = CoinChartData::where('coin_pair_id',  $request->input('coin_pair_id'))->orderBy('id', 'DESC')->first();
        $checkDateDuplication = CoinChartData::where('coin_pair_id',  $request->input('coin_pair_id'))->where('date', $request->input('date'))->orderBy('id', 'DESC')->first();

        if($checkDateDuplication == null)
        {
            $increase_value = $forPercentage->close - $request->input('close') / $forPercentage->close;
            // dd($request->input('volume'));
            $data = CoinChartData::create(array_merge([
            'coin_pair_id' => $request->input('coin_pair_id'),
            'date' => $request->input('date'),
            'open' => $request->input('open'),
            'high' => $request->input('high') ,
            'low' => $request->input('low') ,
            'close' => $request->input('close') ,
            'volume'=> $request->input('volume') ,
            'increase_in_value' =>$increase_value,
            'price_range_from' => $request->input('price_range_from'),
            'price_range_to' =>  $request->input('price_range_to'),
        ]));
        }
        elseif($checkDateDuplication->date == $request->input('date'))
        {
            $increase_value = $forPercentage->close - $request->input('close') / $forPercentage->close;
             $date = $checkDateDuplication->date + 3600000;
            // dd($request->input('volume'));
            $data = CoinChartData::create(array_merge([
            'coin_pair_id' => $request->input('coin_pair_id'),
            'date' => $date,
            'open' => $request->input('open'),
            'high' => $request->input('high') ,
            'low' => $request->input('low') ,
            'close' => $request->input('close') ,
            'volume'=> $request->input('volume') ,
            'increase_in_value' =>$increase_value,
            'price_range_from' => $request->input('price_range_from'),
            'price_range_to' =>  $request->input('price_range_to'),
        ]));
        }
            

        
        

        return response()->json(
            ['chart' => $data]
        );
    }
}
