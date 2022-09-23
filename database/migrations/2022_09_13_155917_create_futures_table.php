<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('futures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('coin_pair_id');
            $table->foreign('coin_pair_id')->references('id')->on('coin_pairs')->onDelete('cascade');
            $table->unsignedBigInteger('client_wallet_future_id');
            $table->foreign('client_wallet_future_id')->references('id')->on('client_wallet_futures')->onDelete('cascade');
            $table->double('opening_price');
            $table->string('leverage');
            $table->string('estimated_force_parity');
            $table->string('margin');
            $table->string('open_interest');
            $table->string('current_price');
            $table->enum('manual_closing_allowed', ['YES', 'NO']);
            $table->double('reached_stop_loss_difference');
            $table->double('total_asset');
            $table->double('reached_take_profit_difference');
            $table->double('income');
            $table->double('rate_of_return');
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
        Schema::dropIfExists('futures');
    }
}
