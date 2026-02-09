<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PointTransaction;

class PointTransactionController extends Controller
{
    /**
     * GET /api/user/points/history
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $transactions = PointTransaction::where('user_id', $user->id)
            ->latest()
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $transactions->through(fn ($t) => [
                'id'          => $t->id,
                'type'        => $t->type,
                'points'      => $t->points,
                'description' => $t->description,
                'source_type' => $t->source_type,
                'source_id'   => $t->source_id,
                'source_name' => $t->source_name,
                'created_at'  => $t->created_at->toDateTimeString(),
            ]),
        ]);
    }
}
