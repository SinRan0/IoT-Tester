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
    \Log::info('Command request:', $request->all());
    
    try {
        Command::create([
            'device_id' => $request->device_id,
            'command' => 'LED_ON',
            'status' => 'pending'
        ]);

        return response()->json(['message' => 'Command sent']);
        
    } catch (\Exception $e) {
        \Log::error('Command error: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    

    // diambil ESP32
    public function getCommand($device_id)
    {
        $cmd = Command::where('device_id', $device_id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if ($cmd) {
            $cmd->status = 'done';
            $cmd->save();

            return response()->json([
                'command' => $cmd->command
            ]);
        }

        return response()->json([
            'command' => null
        ]);
    }
}
