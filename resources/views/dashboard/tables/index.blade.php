@extends('dashboard.master')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card shadow-sm border-0">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h4 class="card-title mb-1">Daftar Meja & QR Code</h4>
              <p class="text-muted mb-0">Scan QR untuk pemesanan dari meja pelanggan.</p>
            </div>
            <a href="{{ route('admin.tables.create') }}" class="btn btn-primary">
              <i class="mdi mdi-plus"></i> Tambah Meja
            </a>
          </div>

          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <i class="mdi mdi-check-circle"></i> {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          @endif

          <div class="table-responsive">
            <table class="table table-hover table-striped mb-0 table-align-middle">
              <thead class="table-light">
                <tr>
                  <th style="width: 60px;">No</th>
                  <th>Nomor Meja</th>
                  <th>Label / Lokasi</th>
                  <th class="text-center" style="width: 180px;">QR Code</th>
                  <th class="text-end" style="width: 150px;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($tables as $table)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>Meja {{ $table->number }}</strong></td>
                    <td>{{ $table->label ?? '-' }}</td>
                    <td>
                      <div class="d-flex flex-column align-items-center gap-2 py-2">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('orders.table', ['tableNumber' => $table->number])) }}" 
                             alt="QR Meja {{ $table->number }}" 
                             class="border p-2 bg-white rounded shadow-sm" 
                             style="width: 100px; height: 100px; object-fit: contain;">
                        
                        <a href="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode(route('orders.table', ['tableNumber' => $table->number])) }}" 
                           target="_blank" 
                           class="btn btn-xs btn-outline-primary py-1 px-2" 
                           style="font-size: 11px; font-weight: 600; text-decoration: none;">
                           <i class="mdi mdi-printer"></i> Buka & Cetak
                        </a>
                      </div>
                    </td>
                    <td class="text-end">
                      <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('admin.tables.edit', $table) }}" class="btn btn-outline-warning" title="Edit">
                          <i class="mdi mdi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('admin.tables.destroy', $table) }}" method="POST" class="d-inline">
                          @method('DELETE')
                          @csrf
                          <button class="btn btn-outline-danger" title="Hapus" onclick="return confirm('Hapus meja ini?')">
                            <i class="mdi mdi-trash-can"></i> Hapus
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                      <i class="mdi mdi-table-furniture" style="font-size: 2.5rem;"></i>
                      <p class="mt-3 mb-0">Belum ada meja terdaftar. Silakan tambahkan meja baru.</p>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    .table-align-middle th,
    .table-align-middle td {
      vertical-align: middle;
    }
    .btn-xs {
      padding: 0.25rem 0.4rem;
      font-size: 0.75rem;
      line-height: 1.5;
      border-radius: 0.2rem;
    }
  </style>
@endsection