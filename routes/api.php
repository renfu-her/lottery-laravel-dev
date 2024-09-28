<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Prize;
use Illuminate\Database\Eloquent\ModelNotFoundException;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('prizes/{prize}/remaining', function (Prize $prize) {
    try {
        return response()->json([
            'success' => true,
            'remaining' => $prize->remaining
        ]);
    } catch (ModelNotFoundException $e) {
        return response()->json([
            'success' => false,
            'message' => '找不到指定的獎品'
        ], 404);
    }
});
