<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientWallet\IndexClientWalletRequest;
use App\Models\Client;
use App\Models\ClientWalletFuture;
use App\Models\Coin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FutureWalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexClientWalletRequest $request)
    {
        //
        $auth = Auth::user();
        if($auth->role =='ADMINISTRATOR')
        {
            $client = ClientWalletFuture::where('client_id', $request->input('client_id'))->with('client','coin')->get();

            return response()->json(
                [
                    'assets' => $client
                ]
            );
        }
        elseif($auth->role == 'CLIENT')
        {
            $client = Client::where('user_id', $auth->id)->first();
            $usdtWallet = ClientWalletFuture::where('client_id', $client->id)->where('coin_id', 1)->with('client')->get();
            $wallet = ClientWalletFuture::where('client_id', $client->id)->with('client', 'coin')->get();
        }

        return response()->json([
            'usdtWallet' => $usdtWallet,
            'wallet' => $wallet
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

    public function getWalletBalance(Request $request)
    {
        $auth = Auth::user();
        if($auth->role == null)
        {
            return response()->json(
                [
                    'message' => 'INVALID ACTION'
                ]
            );
        }
        else{
            $client = Client::where('user_id', $auth->id)->first();
            // dd($client->id);
            $coin = Coin::where('name', $request->input('name'))->first();
            // dd($coin->id);
            $wallet = ClientWalletFuture::where('client_id', $client->id)->where('coin_id', $coin->id)->first();

            // dd($wallet);

            if($wallet == null)
            {
                $wallet = ClientWalletFuture::create(array_merge(
                    [
                    'client_id' => $client->id, 
                    'coin_id' => $coin->id, 
                    'wallet_balance' => 0]
                ));
            }

            return response()->json(
                [
                    'wallet' => $wallet
                ]
            );

        }

        
        
    }
}
