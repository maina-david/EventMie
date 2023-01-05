<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Classiebit\Eventmie\Models\Transaction;
use Classiebit\Eventmie\Models\Booking;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/bookings')->group(function () {
    Route::match(['get', 'post'], '/tinypesa/callback', function (Request $request) {
        logger($request->all());
        $result_code = $request['Body']['stkCallback']['ResultCode'];
        $transaction_id = $request['Body']['stkCallback']['TinyPesaID'];

        $transaction = Transaction::where('txn_id', $transaction_id)->first();

        if ($transaction) {
            if ($result_code == 0) {
                $transaction->status = true;
                $transaction->payment_status = 'SUCCESS';
                $transaction->save();

                $booking = Booking::where('transaction_id', $transaction->id)->first();

                if ($booking) {
                    $booking->is_paid = true;
                    $booking->save();
                }

                return response()->json('success', 200);
            } else {
                $transaction->status = false;
                $transaction->payment_status = 'FAILED';
                $transaction->save();
                return response()->json('success', 200);
            }
        }
    });
});