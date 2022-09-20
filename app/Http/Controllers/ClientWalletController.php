<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientWallet\IndexClientWalletRequest;
use App\Http\Requests\ClientWallet\StoreClientWalletRequest;
use App\Http\Requests\ClientWallet\UpdateClientWalletRequest;
use App\Models\Client;
use App\Models\ClientWallet;
use App\Models\Coin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientWalletController extends Controller
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
            $client = ClientWallet::where('client_id', $request->input('client_id'))->with('client','coin')->get();

            return response()->json(
                [
                    'assets' => $client
                ]
            );
        }
        elseif($auth->role == 'CLIENT')
        {
            $client = Client::where('user_id', $auth->id)->first();
            $usdtWallet = ClientWallet::where('client_id', $client->id)->where('coin_id', 1)->with('client')->get();
            $wallet = ClientWallet::where('client_id', $client->id)->with('client', 'coin')->get();
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
    public function store(StoreClientWalletRequest $request)
    {
        //
        $auth = Auth::user();
        if($auth->role == 'ADMINISTRATOR')
        {
            $clientWallet = ClientWallet::create($request->validated());

            return response()->json(
                [
                    'clientWallet' => $clientWallet
                ]
            );
        }
        elseif($auth->role == 'CLIENT')
        {
            $clientWallet = ClientWallet::create($request->validated());

            return response()->json(
                [
                    'clientWallet' => $clientWallet
                ]
            );
        }
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
    public function update(UpdateClientWalletRequest $request, ClientWallet $clientWallet)
    {
        //
        $auth = Auth::user();
        if($auth->role == 'ADMINISTRATOR')
        {
            $clientWallet = ClientWallet::where('client_wallet_id', $clientWallet)->first();
            $clientWallet->update($request->validated());

            return response()->json(
                [
                    'clientWallet' => $clientWallet
                ]
            );
        }
        elseif($auth->role == 'CLIENT')
        {
            $clientWallet = ClientWallet::where('client_wallet_id', $clientWallet)->first();
            $clientWallet->update($request->validated());

            return response()->json(
                [
                    'clientWallet' => $clientWallet
                ]
            );
        }
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
            $wallet = ClientWallet::where('client_id', $client->id)->where('coin_id', $coin->id)->first();

            // dd($wallet);

            if($wallet == null)
            {
                $wallet = ClientWallet::create(array_merge(
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
