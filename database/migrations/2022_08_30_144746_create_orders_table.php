<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->uuid('uid');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('client_wallet_id');
            $table->foreign('client_wallet_id')->references('id')->on('client_wallets')->onDelete('cascade');
            $table->unsignedBigInteger('coin_pair_id');
            $table->foreign('coin_pair_id')->references('id')->on('coin_pairs')->onDelete('cascade');
            $table->string('role');
            $table->enum('delegate_type', ['BUY', 'SELL']);
            $table->string('state');
            $table->string('number_of_order');
            $table->double('order_per_unit');
            $table->string('total_commission');
            $table->double('final_price');
            $table->string('volume')->nullable();
            $table->string('turnover')->nullable();
            $table->string('commission_time');
            $table->string('last_modified');
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
        Schema::dropIfExists('orders');
    }
}
