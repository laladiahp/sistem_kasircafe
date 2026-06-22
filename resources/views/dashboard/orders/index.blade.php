@extends('dashboard.master')

@section('content')
  <div class="row mb-3">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h4 class="mb-0">Antrian & Pesanan</h4>
          <p class="text-muted mb-0">Kelola semua pesanan dari pelanggan</p>
        </div>
        <div>
          <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">
            <i class="mdi mdi-plus"></i> Tambah Pesanan Kasir
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>Nomor Pesanan</th>
                <th>Meja</th>
                <th>Pelanggan</th>
                <th>Total</th>
                <th>Pembayaran</th>
                <th>Status</th>
                <th>Waktu</th>
                <th style="width: 100px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($orders as $order)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>
                    <strong>{{ $order->order_number }}</strong>
                  </td>
                  <td>
                    <span class="badge bg-light text-dark">Meja {{ $order->table_number }}</span>
                  </td>
                  <td>
                    <h6 class="mb-0">{{ $order->customer_name ?? 'Pelanggan' }}</h6>
                  </td>
                  <td>
                    <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
                  </td>
                  <td>
                    @if($order->payment_method)
                      <span class="badge bg-success">
                        <i class="mdi mdi-check"></i> {{ ucfirst($order->payment_method) }}
                      </span>
                    @else
                      <span class="badge bg-warning">
                        <i class="mdi mdi-clock"></i> Belum Bayar
                      </span>
                    @endif
                  </td>
                  <td>
                    @switch($order->status)
                      @case('pending')
                        <span class="badge bg-danger">
                          <i class="mdi mdi-alert"></i> Pending
                        </span>
                      @break
                      @case('preparing')
                        <span class="badge bg-info">
                          <i class="mdi mdi-chef-hat"></i> Dipersiapkan
                        </span>
                      @break
                      @case('served')
                        <span class="badge bg-primary">
                          <i class="mdi mdi-check"></i> Disajikan
                        </span>
                      @break
                      @case('paid')
                        <span class="badge bg-success">
                          <i class="mdi mdi-check-circle"></i> Selesai
                        </span>
                      @break
                      @default
                        <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                    @endswitch
                  </td>
                  <td>
                    <small class="text-muted">{{ $order->created_at->format('d M H:i') }}</small>
                  </td>
                  <td>
                    <div class="d-flex gap-1 flex-wrap">
                      <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary" title="Lihat Detail">
                        <i class="mdi mdi-eye"></i>
                      </a>
                      @if($order->status === \App\Models\Order::STATUS_PAID)
                        <a href="{{ route('admin.orders.receipt', $order) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="Cetak Struk">
                          <i class="mdi mdi-printer"></i>
                        </a>
                      @endif
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="9" class="text-center py-4 text-muted">
                    <i class="mdi mdi-inbox-multiple" style="font-size: 2rem;"></i>
                    <p class="mt-2">Belum ada pesanan.</p>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
