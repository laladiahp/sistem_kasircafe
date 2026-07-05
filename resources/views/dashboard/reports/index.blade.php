@extends('dashboard.master')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Laporan Penjualan</h4>
          <p class="card-description">Grafik penjualan berdasarkan rentang waktu yang dipilih.</p>

          <form method="GET" action="{{ route('admin.reports.index') }}" class="row g-3 mb-4 align-items-end">
            <div class="col-12 col-md-4">
              <label class="form-label">Tanggal Mulai</label>
              <input type="date" name="start_date" class="form-control" value="{{ old('start_date', optional($start)->format('Y-m-d')) }}">
            </div>
            <div class="col-12 col-md-4">
              <label class="form-label">Tanggal Akhir</label>
              <input type="date" name="end_date" class="form-control" value="{{ old('end_date', optional($end)->format('Y-m-d')) }}">
            </div>
            <div class="col-12 col-md-4">
              <button type="submit" class="btn btn-primary w-100">Terapkan Filter</button>
            </div>
          </form>

          <div class="chart-container mb-4">
            <canvas id="salesChart"></canvas>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Top Kategori</h5>
                  <div class="table-responsive">
                    <table class="table table-sm table-striped">
                      <thead>
                        <tr>
                          <th>Kategori</th>
                          <th>Revenue</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($categorySales as $category)
                          <tr>
                            <td>{{ $category->category }}</td>
                            <td>Rp {{ number_format($category->revenue, 0, ',', '.') }}</td>
                          </tr>
                        @empty
                          <tr>
                            <td colspan="2">Belum ada data penjualan.</td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Produk Terlaris</h5>
                  <div class="table-responsive">
                    <table class="table table-sm table-striped">
                      <thead>
                        <tr>
                          <th>Produk</th>
                          <th>Qty</th>
                          <th>Revenue</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($topProducts as $product)
                          <tr>
                            <td>{{ $product->product }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>Rp {{ number_format($product->revenue, 0, ',', '.') }}</td>
                          </tr>
                        @empty
                          <tr>
                            <td colspan="3">Belum ada data produk.</td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const ctx = document.getElementById('salesChart').getContext('2d');
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: @json($chartLabels),
          datasets: [{
            label: 'Penjualan (Rp)',
            data: @json($chartData),
            borderColor: '#4CAF50',
            backgroundColor: 'rgba(76, 175, 80, 0.2)',
            fill: true,
            tension: 0.25,
            pointRadius: 4,
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: function(context) { return 'Rp ' + Number(context.parsed.y).toLocaleString('id-ID'); } } }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                callback: function(value) {
                  return 'Rp ' + Number(value).toLocaleString('id-ID');
                }
              }
            }
          }
        }
      });
    });
  </script>
@endpush
