@extends('layouts.administrator')

@section('content')


<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h2 class="fw-bold">Dashboard Statistik Arsip</h2>
        <p class="text-muted">
            Statistik dokumen arsip berdasarkan kategori
        </p>
    </div>

    <!-- CARD STATISTIK -->
    <div class="row g-4">
        <div class="col-lg-6 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">

                    <div class="mb-3">
                        <span class="position-relative d-inline-block"> 
                            <!-- Folder -->
                            <i class="bi bi-folder-fill text-success fs-1"></i>

                            <!-- Check di atas folder -->
                            <i class="bi bi-check-circle-fill text-white position-absolute"
                               style="font-size: 1.5rem; bottom: 6px; right: 6px;"></i>

                        </span>
                    </div>

                    <h5 class="fw-bold">
                        ARSIP AKTIF
                    </h5>

                    <h2 class="fw-bold"
                        style="color: green">
                        666
                    </h2>

                    <small class="text-muted">
                        Total Dokumen
                    </small>

                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">

                    <div class="mb-3"> 
                        <span class="position-relative d-inline-block"> 
                            <!-- Folder -->
                            <i class="bi bi-folder-fill text-danger fs-1"></i>

                            <!-- Check di atas folder -->
                            <i class="bi bi-x-circle-fill text-white position-absolute"
                               style="font-size: 1.5rem; bottom: 6px; right: 6px;"></i>

                        </span>
                    </div>

                    <h5 class="fw-bold">
                        ARSIP IN AKTIF
                    </h5>

                    <h2 class="fw-bold"
                        style="color: green">
                        999
                    </h2>

                    <small class="text-muted">
                        Total Dokumen
                    </small>

                </div>
            </div>
        </div>

        @foreach($kategori as $item)

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">

                    <div class="mb-3">
                        <i class="bi {{ $item['icon'] }} fs-1"
                           style="color: {{ $item['color'] }}"></i>
                    </div>

                    <h5 class="fw-bold">
                        {{ $item['nama'] }}
                    </h5>

                    <h2 class="fw-bold"
                        style="color: {{ $item['color'] }}">
                        {{ $item['total'] }}
                    </h2>

                    <small class="text-muted">
                        Total Dokumen
                    </small>

                </div>
            </div>
        </div>

        @endforeach

    </div>

    <!-- GRAFIK -->
    <div class="card border-0 shadow-sm mt-5">
        <div class="card-header bg-white">
            <h5 class="fw-bold mb-0">
                Grafik Statistik Arsip
            </h5>
        </div>

        <div style="height:400px;">
            <canvas id="myChart"></canvas>
        </div> 
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const canvas = document.getElementById('myChart');

    if (!canvas) {
        console.log('Canvas tidak ditemukan');
        return;
    }

    const ctx = canvas.getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                'Arsip Surat',
                'Arsip Keuangan',
                'Arsip Pegawai',
                'Arsip Legal'
            ],
            datasets: [{
                label: 'Jumlah Dokumen',
                data: [120, 85, 64, 42],
                backgroundColor: [
                    '#0d6efd',
                    '#198754',
                    '#ffc107',
                    '#dc3545'
                ],
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    display: false
                }
            },

            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

});
</script>
<script>
  const ctx = document.getElementById('myChartx');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [{
        label: '# of Votes',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
 

</script>

@endsection