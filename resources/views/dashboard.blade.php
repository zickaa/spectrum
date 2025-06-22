@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
  .status-on {
    background-color: #28a745; /* hijau */
    color: white;
  }
  .status-off {
    background-color: #dc3545; /* merah */
    color: white;
  }
</style>

<div class="container py-4">
  <h2 class="mb-4"><i class="fas fa-tachometer-alt"></i> Dashboard Monitoring</h2>

  <div class="row mb-4">
    <!-- Kartu Nutrisi -->
    <div class="col-md-4">
      <div class="card card-custom">
        <div class="card-body text-center">
          <h5 class="card-title text-primary">Status Nutrisi</h5>
          <h2 class="display-4 fw-bold" id="tds">0.0</h2>
          <p class="text-muted">PPM</p>
          <div class="mt-2">
            <span class="badge fs-6 status-off" id="status_nutrisi">
              <i class="fas fa-question-circle" id="nutrisi-icon"></i>
              <span id="status_nutrisi_text">TIDAK ADA DATA</span>
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Kartu Air -->
    <div class="col-md-4">
      <div class="card card-custom">
        <div class="card-body text-center">
          <h5 class="card-title text-primary">Ketinggian Air</h5>
          <h2 class="display-4 fw-bold" id="jarak_air">0.0</h2>
          <p class="text-muted">CM dari sensor</p>
        </div>
      </div>
    </div>

    <!-- Standar Nutrisi -->
    <div class="col-md-4">
      <div class="card card-custom">
        <div class="card-body">
          <h5 class="card-title text-primary text-center">Standar Nutrisi</h5>
          <ul class="list-group list-group-flush small">
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span class="text-warning"><i class="fas fa-arrow-down"></i> Kurang</span>
              <span>&lt; 800 PPM</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span class="text-success"><i class="fas fa-check-circle"></i> Ideal</span>
              <span>800 - 1200 PPM</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span class="text-danger"><i class="fas fa-arrow-up"></i> Berlebihan</span>
              <span>&gt; 1200 PPM</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Status Peralatan -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card card-custom">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0"><i class="fas fa-cogs"></i> Status Peralatan</h5>
        </div>
        <div class="card-body p-0">
          <table class="table table-bordered table-hover mb-0 text-center">
            <thead class="table-light">
              <tr><th>Peralatan</th><th>Status</th></tr>
            </thead>
            <tbody>
              <tr><td>Pompa Nutrisi</td><td><span class="badge status-off" id="pompa_nutrisi">OFF</span></td></tr>
              <tr><td>Pompa Air Bersih</td><td><span class="badge status-off" id="pompa_air">OFF</span></td></tr>
              <tr><td>Pompa Aliran</td><td><span class="badge status-off" id="pompa_aliran">OFF</span></td></tr>
              <tr><td>Dinamo Pengaduk</td><td><span class="badge status-off" id="dinamo_pengaduk">OFF</span></td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
  function updateBadge(id, status) {
    const el = document.getElementById(id);
    if (!el) return;

    // Tangani berbagai tipe status (boolean, number, string)
    let isOn = false;
    if (typeof status === 'boolean') {
      isOn = status;
    } else if (typeof status === 'number') {
      isOn = status === 1;
    } else if (typeof status === 'string') {
      isOn = ['aktif', 'on', '1', 'true'].includes(status.toLowerCase());
    }

    el.className = 'badge ' + (isOn ? 'status-on' : 'status-off');
    el.textContent = isOn ? 'ON' : 'OFF';
  }

  async function fetchTdsData() {
    try {
      const res = await axios.get("/api/tds/latest");
      const data = res.data;

      document.getElementById("tds").textContent = data.nutrisi_ppm ?? "0.0";
      document.getElementById("status_nutrisi_text").textContent = data.status_nutrisi ?? "TIDAK ADA DATA";

      updateBadge("pompa_nutrisi", data.pompa_nutrisi);
      updateBadge("pompa_aliran", data.pompa_aliran);

      // Dinamo pengaduk mengikuti pompa nutrisi
      updateBadge("dinamo_pengaduk", data.pompa_nutrisi);
    } catch (err) {
      console.error("❌ Gagal mengambil data TDS:", err);
    }
  }

  async function fetchUltrasonicData() {
    try {
      const res = await axios.get("/api/ultrasonic/latest");
      const data = res.data;

      document.getElementById("jarak_air").textContent = data.jarak_air ?? "0.0";
      updateBadge("pompa_air", data.pompa_air);
    } catch (err) {
      console.error("❌ Gagal mengambil data ultrasonic:", err);
    }
  }

  // Refresh data setiap 3 detik
  setInterval(() => {
    fetchTdsData();
    fetchUltrasonicData();
  }, 3000);

  // Load data pertama kali saat halaman dibuka
  fetchTdsData();
  fetchUltrasonicData();
</script>
@endsection
