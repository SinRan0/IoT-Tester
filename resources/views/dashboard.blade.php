<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard IoT Monitoring</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="refresh" content="10">

    <style>
        body { margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #0f172a; color: white; }
        .header { padding: 25px; text-align: center; background: #1e293b; font-size: 26px; font-weight: bold; border-bottom: 2px solid #334155; }
        .container { display: flex; justify-content: center; gap: 30px; margin-top: 50px; flex-wrap: wrap; }
        .card { background: #1e293b; padding: 30px; border-radius: 20px; width: 220px; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.5); transition: 0.3s; border: 1px solid #334155; }
        .card:hover { transform: translateY(-5px); border-color: #38bdf8; }
        .value { font-size: 45px; margin-top: 10px; font-weight: bold; color: #38bdf8; }
        .label { font-size: 18px; opacity: 0.8; text-transform: uppercase; letter-spacing: 1px; }
        
        .control-section { text-align: center; margin-top: 50px; background: #1e293b; padding: 40px; margin-left: auto; margin-right: auto; max-width: 500px; border-radius: 20px; }
        .btn-group { display: flex; justify-content: center; gap: 20px; margin-top: 20px; }
        
        .btn { padding: 15px 30px; border: none; border-radius: 12px; color: white; font-size: 16px; font-weight: bold; cursor: pointer; transition: 0.2s; min-width: 150px; }
        .btn-on { background: #22c55e; box-shadow: 0 4px 14px 0 rgba(34, 197, 94, 0.39); }
        .btn-on:hover { background: #16a34a; }
        .btn-off { background: #ef4444; box-shadow: 0 4px 14px 0 rgba(239, 68, 68, 0.39); }
        .btn-off:hover { background: #dc2626; }
        
        .time { margin-top: 40px; text-align: center; opacity: 0.5; font-size: 14px; }
    </style>
</head>
<body>

<div class="header">🌡️ DASHBOARD MONITORING ESP32</div>

<div class="container">
    <div class="card">
        <div class="label">Suhu</div>
        <div class="value">{{ $data->temperature ?? '0' }}°C</div>
    </div>
    <div class="card">
        <div class="label">Kelembapan</div>
        <div class="value">{{ $data->humidity ?? '0' }}%</div>
    </div>
</div>

<div class="control-section">
    <div class="label">Remote Control LED</div>
    <div class="btn-group">
        <button class="btn btn-on" onclick="sendLedCommand('LED_ON')">NYALAKAN 💡</button>
        <button class="btn btn-off" onclick="sendLedCommand('LED_OFF')">MATIKAN 🌑</button>
    </div>
</div>

<div class="time">
    Status terakhir: {{ $data->created_at ?? 'Belum ada data' }}
</div>

<script>
function sendLedCommand(cmd) {
    const url = 'https://iot-tester-production.up.railway.app/api/command';
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            device_id: 'esp32_1',
            command: cmd
        })
    })
    .then(async (res) => {
        const result = await res.json();
        if (!res.ok) throw result;
        alert("Berhasil: " + cmd);
    })
    .catch(err => {
        console.error("FAIL:", err);
        alert("Gagal mengirim perintah ke server!");
    });
}
</script>

</body>
</html>