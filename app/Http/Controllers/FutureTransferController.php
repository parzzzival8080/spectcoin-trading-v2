<?php

namespace App\Http\Controllers;

use App\Http\Requests\FutureTransfer\IndexFutureTransferRequest;
use App\Http\Requests\FutureTransfer\StoreFutureTransferRequest;
use App\Models\ClientWallet;
use App\Models\ClientWalletFuture;
use App\Models\FutureTransfer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FutureTransferController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexFutureTransferRequest $request)
    {
        //
        $futureTransfer = FutureTransfer::with('client');
        return response()->json(
            [
                'transfer' => $futureTransfer
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
    public function store(StoreFutureTransferRequest $request)
    {
        // 
        $mytime = Carbon::now();
        $futureTransfer = FutureTransfer::create(array_merge(
            [
                'state' => 'PENDING',
                'transfer_time' => $mytime->toDateTimeString(),
            ], $request->validated()
        ));

        if($request->input('draw_type') == 'DRAW_IN')
        {
            $clientWallet = ClientWallet::where('client_id', $request->input('client_id'))->first();

            // $clientWalletFuture = ClientWalletFuture::where('client_id', $request->input('client_id'))->first();

            $clientWalletBalance = $clientWallet->wallet_balance - $request->input('transfer_amount');

            $clientWallet->update(
                [
                    'wallet_balance' => $clientWalletBalance
                ]
            );
        }
        elseif($request->input('draw_type') == 'DRAW_OUT')
        {
            // $clientWallet = ClientWallet::where('client_id', $request->input('client_id'))->first();

            $clientWalletFuture = ClientWalletFuture::where('client_id', $request->input('client_id'))->first();

            $clientWalletBalance = $clientWalletFuture->wallet_balance - $request->input('transfer_amount');

            $clientWalletFuture->update(
                [
                    'wallet_balance' => $clientWalletBalance
                ]
            );
        }

        return response()->json(
            [
                'transfer' => $futureTransfer
            ]
        );
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

    public function updateTransfer(Request $request)
    {
        $transfer = FutureTransfer::where('client_id', $request->input('client_id'))->first();
        $clientWalletFuture = ClientWalletFuture::where('client_id', $request->input('client_id'))->first();

        if($transfer->draw_type == 'DRAW_IN')
        {
            if($request->input('status') == 'APPROVED')
            {
                $clientWalletFuture = ClientWalletFuture::where('client_id', $request->input('client_id'))->first();

                $future_balance = $clientWalletFuture + $transfer->transfer_amount;
                
                $clientWalletFuture->update(
                    [
                        'wallet_balance' => $future_balance
                    ]
                );

                $transfer->update(
                    [
                        'state' => $request->input('status')
                    ]
                );
            }

            elseif($request->input('status') == 'DECLINED')
            {
                $clientWallet = ClientWallet::where('client_id', $request->input('client_id'))->first();

                $wallet_balance = $clientWallet + $transfer->transfer_amount;
                
                $clientWallet->update(
                    [
                        'wallet_balance' => $wallet_balance
                    ]
                );

                $transfer->update(
                    [
                        'state' => $request->input('status')
                    ]
                );
            }
        }elseif($transfer->draw_type == 'DRAW_OUT')
        {
            if($request->input('status') == 'APPROVED')
            {
                $clientWallet = ClientWallet::where('client_id', $request->input('client_id'))->first();

                $wallet_balance = $clientWallet + $transfer->transfer_amount;
                
                $clientWallet->update(
                    [
                        'wallet_balance' => $wallet_balance
                    ]
                );

                $transfer->update(
                    [
                        'state' => $request->input('status')
                    ]
                );
            }

            elseif($request->input('status') == 'DECLINED')
            {

                $clientWalletFuture = ClientWalletFuture::where('client_id', $request->input('client_id'))->first();

                $future_balance = $clientWalletFuture + $transfer->transfer_amount;
                
                $clientWalletFuture->update(
                    [
                        'wallet_balance' => $future_balance
                    ]
                );

                $transfer->update(
                    [
                        'state' => $request->input('status')
                    ]
                );

                
            }
        }
    }
}
