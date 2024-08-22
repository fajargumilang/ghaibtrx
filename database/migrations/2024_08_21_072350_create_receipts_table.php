<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->string('store_name');
            $table->string('address');
            $table->string('hp');
            $table->string('trans');
            $table->string('kassa');
            $table->time('time_transaction');

            $table->string('member');
            $table->string('name_of_kassa');
            $table->string('pt_akhir');

            $table->string('receipt_number')->unique();

            $table->integer('total_amount');
            $table->integer('discount')->default(0);
            $table->integer('tax')->default(0);
            $table->bigInteger('uang_tunai');
            $table->integer('final_amount');

            $table->enum('payment_method', ['cash', 'card', 'online']);
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
        Schema::dropIfExists('receipts');
    }
}
