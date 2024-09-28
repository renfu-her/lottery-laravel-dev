<?php

namespace App\Http\Controllers;

use App\Models\Prize;
use App\Models\User;
use App\Models\Winner;
use Illuminate\Http\Request;

class LotteryController extends Controller
{
    public function draw()
    {
        $prizes = Prize::where('remaining', '>', 0)->get();
        $users = User::all();

        if ($prizes->isEmpty() || $users->isEmpty()) {
            return redirect()->route('prizes.index')->with('error', '没有可用的奖品或用户');
        }

        $prize = $prizes->random();
        $user = $users->random();

        Winner::create([
            'user_id' => $user->id,
            'prize_id' => $prize->id,
        ]);

        $prize->decrement('remaining');

        return redirect()->route('prizes.index')->with('success', "{$user->name} 赢得了 {$prize->name}");
    }

    public function assign(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'prize_id' => 'required|exists:prizes,id',
        ]);

        $prize = Prize::findOrFail($validated['prize_id']);

        if ($prize->remaining <= 0) {
            return redirect()->route('prizes.index')->with('error', '该奖品已无剩余');
        }

        Winner::create([
            'user_id' => $validated['user_id'],
            'prize_id' => $validated['prize_id'],
        ]);

        $prize->decrement('remaining');

        $user = User::findOrFail($validated['user_id']);
        return redirect()->route('prizes.index')->with('success', "已将 {$prize->name} 分配给 {$user->name}");
    }
}
