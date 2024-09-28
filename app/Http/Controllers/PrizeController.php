<?php

namespace App\Http\Controllers;

use App\Models\Prize;
use Illuminate\Http\Request;

class PrizeController extends Controller
{
    public function index()
    {
        $prizes = Prize::all();
        return view('prizes.index', compact('prizes'));
    }

    public function create()
    {
        return view('prizes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        $prize = Prize::create([
            'name' => $validated['name'],
            'quantity' => $validated['quantity'],
            'remaining' => $validated['quantity'],
        ]);

        return redirect()->route('prizes.index')->with('success', '奖品添加成功');
    }
}
