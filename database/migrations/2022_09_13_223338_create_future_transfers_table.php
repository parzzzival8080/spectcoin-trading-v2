<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFutureTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('future_transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('coin_pair_id');
            $table->foreign('coin_pair_id')->references('id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('client_wallet_future_id');
            $table->foreign('client_wallet_future_id')->references('id')->on('client_wallet_futures')->onDelete('cascade');
            $table->enum('draw_type', ['DRAW_IN', 'DRAW_OUT']);
            $table->enum('state', ['PENDING', 'APPROVED', 'DECLINED']);
            $table->double('transfer_amount');
            $table->string('transfer_time');
            $table->string('review_time')->nullable();
            $table->string('auditor')->nullable();
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('future_transfers');
    }
}
