<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientWalletFuturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_wallet_futures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_wallet_id');
            $table->foreign('client_wallet_id')->references('id')->on('client_wallets')->delete('cascade');
            $table->unsignedBigInteger('coin_id');
            $table->foreign('coin_id')->references('id')->on('coins')->delete('cascade');
            $table->double('wallet_balance')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_wallet_futures');
    }
}
