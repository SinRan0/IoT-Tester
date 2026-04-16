<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard IoT</title>

<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="refresh" content="5">

<style>
body {
    margin: 0;
    font-family: Arial;
    background: #0f172a;
    color: white;
}

.header {
    padding: 20px;
    text-align: center;
    background: #1e293b;
    font-size: 24px;
    font-weight: bold;
}

.container {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin-top: 50px;
}

.card {
    background: #1e293b;
    padding: 30px;
    border-radius: 20px;
    width: 220px;
    text-align: center;
    box-shadow: 0 10px 25px rgba(0,0,0,0.5);
    transition: 0.3s;
}

.card:hover {
    transform: scale(1.05);
}

.value {
    font-size: 40px;
    margin-top: 10px;
}

.label {
    font-size: 18px;
    opacity: 0.7;
}

.btn {
    margin-top: 40px;
    padding: 15px 30px;
    border: none;
    border-radius: 10px;
    background: #22c55e;
    color: white;
    font-size: 18px;
    cursor: pointer;
}

.btn:hover {
    background: #16a34a;
}

.time {
    margin-top: 30px;
    text-align: center;
    opacity: 0.6;
}
</style>
</head>

<body>

<div class="header">
    🌡️ Dashboard IoT Monitoring
</div>

<div class="container">

    <div class="card">
        <div class="label">Suhu</div>
        <div class="value">
            {{ $data->temperature ?? '-' }} °C
        </div>
    </div>

    <div class="card">
        <div class="label">Kelembapan</div>
        <div class="value">
            {{ $data->humidity ?? '-' }} %
        </div>
    </div>

</div>

<div style="text-align:center;">
    <button class="btn" onclick="nyalakanLED()">Nyalakan LED 💡</button>
</div>

<div class="time">
    Update terakhir:
    {{ $data->created_at ?? '-' }}
</div>

<script>
function nyalakanLED() {
    fetch('http://192.168.0.113:8000/api/command', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            device_id: 'esp32_1'
        })
    })
    .then(res => res.json())
    .then(data => {
        alert("LED berhasil dinyalakan 🔥");
    })
    .catch(err => {
        alert("Gagal kirim command");
        console.log(err);
    });
}
</script>

</body>
</html>
