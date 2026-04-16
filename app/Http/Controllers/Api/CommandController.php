<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Command;
use Illuminate\Support\Facades\DB;

class CommandController extends Controller
{

public function store(Request $request)
{
    try {
        // Validasi input
        $request->validate([
            'device_id' => 'required',
            'command' => 'required|in:LED_ON,LED_OFF', // Memastikan hanya ON/OFF yang masuk
        ]);

        $cmd = Command::create([
            'device_id' => $request->device_id,
            'command' => $request->command,
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Command ' . $request->command . ' sent!',
            'data' => $cmd
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
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

            $cmd->update([
                'status' => 'done'
            ]);

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

    // DEBUG (AMAN)
    public function test()
    {
        return response()->json([
            'db' => DB::connection()->getDatabaseName()
        ]);
    }
}
