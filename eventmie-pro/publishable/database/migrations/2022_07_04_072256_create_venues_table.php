<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::create('venues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('venue_type')->nullable();
            $table->text('amenities')->nullable();
            $table->string('slug')->unique();
            $table->integer('seated_guestnumber')->nullable();
            $table->integer('standing_guestnumber')->nullable();
            $table->text('neighborhoods')->nullable();
            $table->text('pricing')->nullable();
            $table->text('availability')->nullable();
            $table->text('food')->nullable();
            $table->boolean('show_quoteform')->default(0);
            $table->string('contact_email')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('glat')->nullable();
            $table->string('glong')->nullable();
            $table->text('images');

            if(DB::getSchemaBuilder()->getColumnType('users', 'id') == 'integer') {
                $table->integer('organizer_id')->unsigned()->index();
            } else {
                $table->bigInteger('organizer_id')->unsigned()->index();
            }
            
            $table->foreign('organizer_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('venues');
    }
}
