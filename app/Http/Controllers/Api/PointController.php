<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PointWallet;

class PointController extends Controller
{
    /**
     * GET /api/user/points/wallet
     */
    public function wallet(Request $request)
    {
        $wallet = PointWallet::ofUser($request->user()->id);

        return response()->json([
            'success' => true,
            'data' => [
                'balance' => $wallet->balance
            ]
        ]);
    }
}
