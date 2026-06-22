<?php

use App\Events\MessageSent;
use App\Events\UserJoined;
use App\Events\UserLeft;
use App\Events\UserTyping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Join chat (just validates username, no DB)
Route::post('/join', function (Request $request) {
    $request->validate(['username' => 'required|string|min:2|max:20']);

    $username = trim($request->username);

    broadcast(new UserJoined($username));

    return response()->json(['username' => $username]);
});

// Leave chat
Route::post('/leave', function (Request $request) {
    $request->validate(['username' => 'required|string']);
    broadcast(new UserLeft($request->username));

    return response()->json(['ok' => true]);
});

// Send a message
// Route::post('/message', function (Request $request) {
//     $request->validate([
//         'username' => 'required|string',
//         'message' => 'required|string|max:500',
//     ]);

//     broadcast(new MessageSent(
//         username: $request->username,
//         message: $request->message,
//         timestamp: now()->toIso8601String(),
//     ));

//     return response()->json(['ok' => true]);
// });

Route::post('/message', function (Request $request) {
    $request->validate([
        'username' => 'required|string',
        'message' => 'required|string|max:500',
    ]);

    Log::info('Broadcasting MessageSent', [
        'username' => $request->username,
        'message' => $request->message,
    ]);

    broadcast(new MessageSent(
        username: $request->username,
        message: $request->message,
        timestamp: now()->toIso8601String(),
    ));

    return response()->json(['ok' => true]);
});

// Typing indicator
Route::post('/typing', function (Request $request) {
    $request->validate([
        'username' => 'required|string',
        'isTyping' => 'required|boolean',
    ]);

    // broadcastToOthers would need socket_id — for simplicity we broadcast to all
    // and filter on the frontend
    broadcast(new UserTyping(
        username: $request->username,
        isTyping: $request->isTyping,
    ));

    return response()->json(['ok' => true]);
});
