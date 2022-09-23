<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\IndexClientRequest;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client;
use App\Models\ClientWallet;
use App\Models\Coin;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexClientRequest $request)
    {
        //
        $auth = Auth::user();
        if($auth->role == 'ADMINISTRATOR')
        {
            $clients = Client::with('user', 'clientWallets', 'clientDeposits', 'clientWithdraws', 'orders')->get();

            return response()->json(
                [
                    'clients' => $clients
                    ]
            );
        }
        elseif($auth->role == 'CLIENT')
        {
            $client = Client::where('user_id', $auth->id)->with('user', 'clientWallets', 'clientDeposits', ' clientWithdraws', 'orders')->first();

            return response()->json(
                [
                    'clients' => $client
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
    public function store(StoreClientRequest $request)
    {
       

        $referralCode = random_int(100000, 999999);
        $client = Client::where('referral_code', $referralCode)->first();
        if($client->referral_code == null)
        {
            $user = User::create($request->validated());
        // dd($user->id);
            $client = Client::create(array_merge($request->validated(), ['referral_code' => $referralCode, 'user_id' => $user->id, 'state' => 'PENDING', 'registered_ip' => $request->ip()]));
            $referral = Referral::create(array_merge([
                'client_id' => $client->id,
                'referral_code' => $referralCode,
                'total_deposits' => 0,
                'total_incentives' => 0
            ]));

            $coins = Coin::all();
            
            foreach($coins as $coin)
            {
                $clientWallet = ClientWallet::create([
                    'client_id' => $client->id,
                    'coin_id' => $coin->id,
                    'wallet_balance' => 0
                ]);
            } 

        return response()->json(
            [
                'client' => $client
            ]
        );
        }
        elseif($client->referral_code == $referralCode)
        {
            $newReferralCode = random_int(100000, 999999);
            $serialNumber = str_pad($client->id + 1, 7, "0", STR_PAD_LEFT);

            $user = User::create($request->validated());
        // dd($user->id);
            $client = Client::create(array_merge($request->validated(), ['serial_number' => $serialNumber, 
            'user_id' => $user->id, 'state' => 'PENDING', 
            'registered_ip' => $request->ip()]));

            $coins = Coin::all();
            
            foreach($coins as $coin)
            {
                $clientWallet = ClientWallet::create([
                    'client_id' => $client->id,
                    'coin_id' => $coin->id,
                    'wallet_balance' => 0
                ]);
            }

            $referral = Referral::create(array_merge([
                'client_id' => $client->id,
                'referral_code' => $referralCode,
                'total_deposits' => 0,
                'total_incentives' => 0
            ]));
                                                             
            return response()->json(
                [
                    'client' => $client
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
    public function update(UpdateClientRequest $request, Client $client)
    {
        //
        // dd($client->id);
        $client = Client::where('id', $client->id)->first();
        $user = User::where('id', $client->user_id)->first();
        $user->update($request->validated());
        $client->update($request->validated());
        return response()->json(
            [
                'client' => $client
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

}
