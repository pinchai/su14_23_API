<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use KHQR\BakongKHQR;
use KHQR\Helpers\KHQRData;
use KHQR\Models\IndividualInfo;

class KhqrController extends Controller
{
    //
    public function generateQRCode(Request $request)
    {
        $amount = intval($request->amount) * 4100 ?? 100;
        $individualInfo = new IndividualInfo(
            bakongAccountID: 'choeurn_pinchai@aclb',
            merchantName: 'Choeurn Pinchai',
            merchantCity: 'PHNOM PENH',
            currency: KHQRData::CURRENCY_KHR,
            amount: $amount
        );
        $response = BakongKHQR::generateIndividual($individualInfo);
        return response()->json($response);
    }

    public function checkTransactionByMD5(Request $request)
    {
        $md5 = $request->md5;
        $bakongKhqr = new BakongKHQR('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkYXRhIjp7ImlkIjoiYjc3Y2EyOWY5YzdlNDJhNiJ9LCJpYXQiOjE3NTQwNDE1NjksImV4cCI6MTc2MTgxNzU2OX0.HotVhIQevz3RuGEw4z5oySIGW45J6OWijGOUcSBOn80');
        $response = $bakongKhqr->checkTransactionByMD5($md5);
        return response()->json($response);
    }
}
