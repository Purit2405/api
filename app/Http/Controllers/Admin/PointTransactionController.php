<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PointTransaction;
use App\Models\PointWallet;   // ✅ สำคัญ
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PointTransactionController extends Controller
{
    public function index()
    {
        $transactions = PointTransaction::with(['user','source'])
            ->latest()
            ->paginate(15);

        return view('admin.point-transactions.index', compact('transactions'));
    }

    public function create()
    {
        return view('admin.point-transactions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone'  => 'required',
            'points' => 'required|integer|min:1',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return back()->withErrors(['phone' => 'ไม่พบผู้ใช้เบอร์นี้']);
        }

        DB::transaction(function () use ($user, $request) {

            $wallet = PointWallet::firstOrCreate(
                ['user_id' => $user->id],
                ['balance' => 0]
            );

            $wallet->increment('balance', $request->points);

            PointTransaction::create([
                'user_id'     => $user->id,
                'type'        => 'earn',
                'source_type' => null,
                'source_id'   => null,
                'points'      => $request->points,
                'description' => 'เพิ่มแต้มโดยแอดมิน',
            ]);
        });

        return redirect()
            ->route('admin.point-transactions.index')
            ->with('success', 'เพิ่มแต้มเรียบร้อยแล้ว');
    }
}
