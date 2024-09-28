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
        $users = User::whereDoesntHave('winners')->get();

        if ($prizes->isEmpty() || $users->isEmpty()) {
            return response()->json(['status' => 'finished']);
        }

        $prize = $prizes->random();
        $winner = $users->random();

        Winner::create([
            'user_id' => $winner->id,
            'prize_id' => $prize->id,
        ]);

        $prize->decrement('remaining');

        if ($winner && $prize) {
            return response()->json([
                'status' => 'success',
                'winner' => $winner->name,
                'prize' => $prize->name,
                'prize_id' => $prize->id
            ]);
        }

        return response()->json([
            'status' => 'success',
            'winner' => $winner->name,
            'prize' => $prize->name
        ]);
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

        $user = User::findOrFail($validated['user_id']);

        Winner::create([
            'user_id' => $user->id,
            'prize_id' => $prize->id,
        ]);

        $prize->decrement('remaining');

        return redirect()->route('prizes.index')->with('success', "已将 {$prize->name} 分配给 {$user->name}");
    }

    public function winners()
    {
        $winners = Winner::with(['user', 'prize'])->latest()->get();
        return view('lottery.winners', compact('winners'));
    }
}
