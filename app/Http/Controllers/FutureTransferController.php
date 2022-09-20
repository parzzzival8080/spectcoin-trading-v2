<?php

namespace App\Http\Controllers;

use App\Http\Requests\FutureTransfer\IndexFutureTransferRequest;
use App\Http\Requests\FutureTransfer\StoreFutureTransferRequest;
use App\Models\Client;
use App\Models\ClientWallet;
use App\Models\ClientWalletFuture;
use App\Models\FutureTransfer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $auth = Auth::user();

        if($auth->role == 'ADMINISTRATOR')
        {
            $futureTransfer = FutureTransfer::where('state', 'PENDING')->with('client', 'coin')->get();
        return response()->json(
            [
                'transfer' => $futureTransfer
            ]
        );
        }
        
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

    public function updateTransfer(Request $request)
    {
        $transfer = FutureTransfer::where('client_id', $request->input('client_id'))->where('id', $request->input('transfer_id'))->first();
        // dd($transfer->state);
        $clientWalletFuture = ClientWalletFuture::where('client_id', $request->input('client_id'))->first();

        if($transfer->draw_type == 'DRAW_IN')
        {
            if($request->input('state') == 'APPROVED')
            {
                $clientWalletFuture = ClientWalletFuture::where('client_id', $request->input('client_id'))->first();

                $future_balance = $clientWalletFuture->wallet_balance + $transfer->transfer_amount;
                
                $clientWalletFuture->update(
                    [
                        'wallet_balance' => $future_balance
                    ]
                );

                $transfer->update(
                    [
                        'state' => $request->input('state')
                    ]
                );
            }

            elseif($request->input('state') == 'DECLINED')
            {
                $clientWallet = ClientWallet::where('client_id', $request->input('client_id'))->first();

                $wallet_balance = $clientWallet->wallet_balance + $transfer->transfer_amount;

                $clientWallet->update(
                    [
                        'wallet_balance' => $wallet_balance
                    ]
                );

                $transfer->update(
                    [
                        'state' => $request->input('state')
                    ]
                );
                return response()->json([
                    'transfer' => $transfer
                ]);
            }
        }elseif($transfer->draw_type == 'DRAW_OUT')
        {
            if($request->input('state') == 'APPROVED')
            {
                $clientWallet = ClientWallet::where('client_id', $request->input('client_id'))->first();

                $wallet_balance = $clientWallet->wallet_balance + $transfer->transfer_amount;
                
                $clientWallet->update(
                    [
                        'wallet_balance' => $wallet_balance
                    ]
                );

                $transfer->update(
                    [
                        'state' => $request->input('state')
                    ]
                );
                
            }

            elseif($request->input('state') == 'DECLINED')
            {
                $clientWalletFuture = ClientWalletFuture::where('client_id', $request->input('client_id'))->first();

                $future_balance = $clientWalletFuture->wallet_balance + $transfer->transfer_amount;
                
                $clientWalletFuture->update(
                    [
                        'wallet_balance' => $future_balance
                    ]
                );

                $transfer->update(
                    [
                        'state' => $request->input('state')
                    ]
                );

                

                
            }
        }
    }

    public function transfer(StoreFutureTransferRequest $request)
    {
        $mytime = Carbon::now();
        $auth = Auth::user();
        $client = Client::where('user_id', $auth->id)->first();
        $clientWallet = ClientWallet::where('client_id', $client->id)->first();
        $clientWalletFuture = ClientWalletFuture::where('client_id', $client->id)->first();
        
        $futureTransfer = FutureTransfer::create(array_merge(
            [
                'client_id' => $client->id,
                'client_wallet_id' => $clientWallet->id,
                'client_wallet_future_id' => $clientWalletFuture->id,
                'draw_type' => $request->input('draw_type'),
                'state' => 'PENDING',
                'transfer_time' => $mytime->toDateTimeString(),
            ], $request->validated()
        ));

        if($request->input('draw_type') == 'DRAW_IN')
        {
           

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
}
