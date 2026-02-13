@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<style>
    /* Premium Welcome Card */
    .welcome-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 30px;
        padding: 2.5rem;
        margin-bottom: 2.5rem;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
    }

    .welcome-card::after {
        content: "";
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .welcome-card h1 {
        font-weight: 800;
        color: #ffffff;
        letter-spacing: -1px;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
    }

    .welcome-card p {
        color: rgba(255, 255, 255, 0.85);
        font-weight: 500;
        font-size: 1.1rem;
        margin-bottom: 0;
        position: relative;
        z-index: 2;
    }

    /* Glossy Stat Card Style */
    .stat-card {
        background: #ffffff;
        border-radius: 28px;
        padding: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.7);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        z-index: 1;
        height: 100%;
    }

    /* Glossy Shine Effect Overlay */
    .stat-card::before {
        content: "";
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.6) 0%, transparent 70%);
        transform: rotate(30deg);
        transition: 0.8s;
        pointer-events: none;
        opacity: 0;
    }

    .stat-card:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
        border-color: var(--primary-green);
    }

    .stat-card:hover::before {
        opacity: 1;
        top: -20%;
        left: -20%;
    }

    /* Gradient Icon Box */
    .icon-box {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        margin-bottom: 1.5rem;
        color: white;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .grad-emerald { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    .grad-blue { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
    .grad-orange { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }

    /* Chart Box Styling */
    .chart-container {
        background: #ffffff;
        border-radius: 35px;
        padding: 2.5rem;
        margin-top: 2.5rem;
        border: 1px solid rgba(0,0,0,0.02);
        box-shadow: 0 20px 40px rgba(0,0,0,0.04);
    }

    .badge-status {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        font-weight: 700;
        padding: 8px 16px;
        border-radius: 12px;
    }
</style>

<div class="welcome-card text-center text-md-start">
    <div class="d-md-flex align-items-center justify-content-between">
        <div>
            <h1>Hello, Administrator!</h1>
            <p>Pantau aktivitas dan statistik perpustakaan dalam satu panel kendali.</p>
        </div>
        <div class="d-none d-md-block">
            <i class="bi bi-stars text-white opacity-50" style="font-size: 3rem;"></i>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-12 col-md-4">
        <div class="stat-card">
            <div class="icon-box grad-emerald">
                <i class="bi bi-journal-text"></i>
            </div>
            <h6 class="text-uppercase text-muted fw-bold small mb-2">Koleksi Buku</h6>
            <h2 class="display-6 fw-800 mb-1" style="color: #1e293b;">{{ $totalBooks ?? 0 }}</h2>
            <div class="d-flex align-items-center mt-3 text-success small fw-bold">
                <i class="bi bi-check-circle-fill me-2"></i> <span>Tersedia di Rak</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="stat-card">
            <div class="icon-box grad-blue">
                <i class="bi bi-arrow-repeat"></i>
            </div>
            <h6 class="text-uppercase text-muted fw-bold small mb-2">Peminjaman Aktif</h6>
            <h2 class="display-6 fw-800 mb-1" style="color: #1e293b;">{{ $borrowToday ?? 0 }}</h2>
            <div class="d-flex align-items-center mt-3 text-primary small fw-bold">
                <i class="bi bi-lightning-charge-fill me-2"></i> <span>Live Monitoring</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="stat-card">
            <div class="icon-box grad-orange">
                <i class="bi bi-cash-stack"></i>
            </div>
            <h6 class="text-uppercase text-muted fw-bold small mb-2">Total Denda</h6>
            <h2 class="display-6 fw-800 mb-1" style="color: #1e293b;">Rp {{ number_format($totalFines ?? 0, 0, ',', '.') }}</h2>
            <div class="d-flex align-items-center mt-3 text-warning small fw-bold">
                <i class="bi bi-clock-history me-2"></i> <span>Belum Lunas</span>
            </div>
        </div>
    </div>
</div>

<div class="chart-container">
    <div class="d-flex align-items-center justify-content-between mb-5 flex-wrap gap-3">
        <div>
            <h4 class="fw-800 mb-1" style="color: #1e293b;">Grafik Aktivitas</h4>
            <p class="text-muted small mb-0">Statistik peminjaman buku 7 hari terakhir</p>
        </div>
        <span class="badge-status">
            <i class="bi bi-graph-up-arrow me-2"></i>Data Realtime
        </span>
    </div>
    <div style="position: relative; height: 350px;">
        <canvas id="loanChart"></canvas>
    </div>
</div>

@endsection

@section('scripts')
<script>
    fetch("{{ url('/admin/loan-stats') }}")
        .then(res => res.json())
        .then(data => {
            const labels = data.length ? data.map(item => item.date).reverse() :
                Array.from({length:7}, (_,i) => `Day ${i+1}`);
            const counts = data.length ? data.map(item => item.count).reverse() :
                Array(7).fill(0);

            const ctx = document.getElementById('loanChart').getContext('2d');
            
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(16, 185, 129, 0.4)');
            gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Peminjaman',
                        data: counts,
                        backgroundColor: gradient,
                        borderColor: '#10b981',
                        borderWidth: 4,
                        tension: 0.45,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#10b981',
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 9,
                        pointHoverBackgroundColor: '#10b981',
                        pointHoverBorderColor: '#fff',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleFont: { size: 14, family: 'Plus Jakarta Sans', weight: 'bold' },
                            bodyFont: { size: 13, family: 'Plus Jakarta Sans' },
                            padding: 15,
                            cornerRadius: 15,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9', drawBorder: false },
                            ticks: { 
                                color: '#94a3b8',
                                font: { weight: '600' },
                                stepSize: 1 
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { 
                                color: '#94a3b8',
                                font: { weight: '600' }
                            }
                        }
                    }
                }
            });
        })
        .catch(err => console.error('Chart error:', err));
</script>
@endsection