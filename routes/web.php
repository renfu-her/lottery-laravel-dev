<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrizeController;
use App\Http\Controllers\LotteryController;

Route::get('/', [PrizeController::class, 'index'])->name('prizes.index');
Route::get('/prizes/create', [PrizeController::class, 'create'])->name('prizes.create');
Route::post('/prizes', [PrizeController::class, 'store'])->name('prizes.store');

Route::get('/lottery/draw', [LotteryController::class, 'draw'])->name('lottery.draw');
Route::post('/lottery/assign', [LotteryController::class, 'assign'])->name('lottery.assign');
Route::get('/lottery/winners', [LotteryController::class, 'winners'])->name('lottery.winners');
