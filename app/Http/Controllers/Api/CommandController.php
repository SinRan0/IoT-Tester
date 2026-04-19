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
            // VALIDASI (SUDAH SUPPORT POMPA)
            $request->validate([
                'device_id' => 'required',
                'command' => 'required|in:PUMP_ON,PUMP_OFF,LED_ON,LED_OFF',
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
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ESP32 ambil command
    public function getCommand($device_id)
    {
        try {
            $cmd = Command::where('device_id', $device_id)
                ->where('status', 'pending')
                ->latest()
                ->first();

            if (!$cmd) {
                return response()->json([
                    'command' => null
                ]);
            }

            // tandai sudah diambil
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

    // DEBUG
    public function test()
    {
        return response()->json([
            'db' => DB::connection()->getDatabaseName()
        ]);
    }
}
