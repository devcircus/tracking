<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('schedule_date')->nullable()->index();
            $table->integer('order_number')->nullable()->index();
            $table->integer('voucher')->nullable();
            $table->string('sew_house')->nullable()->index();
            $table->integer('quantity')->nullable();
            $table->string('print_house')->nullable()->index();
            $table->dateTime('print_complete')->nullable()->index();
            $table->dateTime('print_start')->nullable();
            $table->integer('days')->nullable()->index();
            $table->dateTime('rush_date')->nullable()->index();
            $table->string('customer')->nullable()->index();
            $table->string('late_reason')->nullable()->index();
            $table->boolean('remake')->nullable()->index();
            $table->dateTime('received_date')->nullable()->index();
            $table->dateTime('cut_date')->nullable()->index();
            $table->string('style')->nullable()->index();
            $table->string('cut_house')->nullable()->index();
            $table->dateTime('report_created');
            $table->text('info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
