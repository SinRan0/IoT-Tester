<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Command;

class CommandController extends Controller
{
    // kirim command dari web
public function store(Request $request)
{
    try {
        \Log::info('REQUEST:', $request->all());

        $cmd = Command::create([
            'device_id' => $request->device_id,
            'command' => $request->command,
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'success',
            'data' => $cmd
        ]);

    } catch (\Exception $e) {

        \Log::error('COMMAND ERROR: ' . $e->getMessage());

        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }
} 

    // diambil ESP32
public function getCommand($device_id)
{
    try {
        $cmd = Command::where('device_id', $device_id)
            ->where('status', 'pending')
            ->orderBy('id', 'desc')
            ->first();

        if (!$cmd) {
            return response()->json([
                'command' => null
            ]);
        }

        Command::where('id', $cmd->id)
            ->update(['status' => 'done']);

        return response()->json([
            'command' => $cmd->command
        ]);

    } catch (\Exception $e) {

        \Log::error("GET COMMAND ERROR: " . $e->getMessage());

        return response()->json([
            'command' => null,
            'error' => 'internal error'
        ], 500);
    }
}

public function test()
{
    dd(DB::connection()->getDatabaseName());
}

}
