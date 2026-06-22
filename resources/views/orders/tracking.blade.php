@extends('layouts.customer')

@section('title', 'Status Pesanan')

@section('content')
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="mdi mdi-check-circle"></i> {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
          <h4 class="card-title mb-1">Status Pesanan</h4>
          <p class="card-description">{{ $order->order_number }}</p>

          <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span>Meja {{ $order->table_number }}</span>
              <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'preparing' ? 'info' : ($order->status === 'served' ? 'primary' : ($order->status === 'paid' ? 'success' : 'secondary'))) }}">
                {{ ucfirst($order->status) }}
              </span>
            </div>
          </div>

          <!-- Status Timeline -->
          <div class="timeline">
            <div class="timeline-item {{ in_array($order->status, ['preparing', 'served', 'paid']) ? 'completed' : '' }}">
              <div class="timeline-marker bg-{{ in_array($order->status, ['preparing', 'served', 'paid']) ? 'success' : 'secondary' }}"></div>
              <div class="timeline-content">
                <h6 class="mb-0">Pesanan Diterima</h6>
                <small class="text-muted">{{ $order->created_at->format('d M H:i') }}</small>
              </div>
            </div>

            <div class="timeline-item {{ in_array($order->status, ['served', 'paid']) ? 'completed' : '' }}">
              <div class="timeline-marker bg-{{ in_array($order->status, ['served', 'paid']) ? 'success' : 'secondary' }}"></div>
              <div class="timeline-content">
                <h6 class="mb-0">Sedang Dipersiapkan</h6>
                <small class="text-muted">
                  @if(in_array($order->status, ['served', 'paid']))
                    {{ $order->updated_at->format('d M H:i') }}
                  @else
                    Menunggu...
                  @endif
                </small>
              </div>
            </div>

            <div class="timeline-item {{ in_array($order->status, ['paid']) ? 'completed' : '' }}">
              <div class="timeline-marker bg-{{ $order->status === 'paid' ? 'success' : 'secondary' }}"></div>
              <div class="timeline-content">
                <h6 class="mb-0">Sudah Siap Disajikan</h6>
                <small class="text-muted">
                  @if($order->status === 'paid')
                    {{ $order->updated_at->format('d M H:i') }}
                  @else
                    Menunggu...
                  @endif
                </small>
              </div>
            </div>

            <div class="timeline-item {{ $order->status === 'paid' ? 'completed' : '' }}">
              <div class="timeline-marker bg-{{ $order->status === 'paid' ? 'success' : 'secondary' }}"></div>
              <div class="timeline-content">
                <h6 class="mb-0">Pembayaran Selesai</h6>
                <small class="text-muted">
                  @if($order->status === 'paid')
                    {{ $order->updated_at->format('d M H:i') }}
                  @else
                    Menunggu pembayaran...
                  @endif
                </small>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Queue Position -->
      @if($order->status === 'pending' || $order->status === 'preparing')
        <div class="card shadow-sm border-0 mb-4">
          <div class="card-body">
            <h5 class="card-title mb-3">Posisi Antrian</h5>
            <div class="alert alert-info mb-0">
              <div class="text-center">
                <h2 class="mb-2" style="color: #0c63e4;">{{ $queuePosition }}</h2>
                <p class="mb-0">Pesanan Anda berada di urutan ke-{{ $queuePosition }} dalam antrian</p>
              </div>
            </div>
          </div>
        </div>
      @endif

      <!-- Order Details -->
      <div class="card shadow-sm border-0">
        <div class="card-body">
          <h5 class="card-title mb-3">Detail Pesanan</h5>
          <div class="table-responsive">
            <table class="table table-borderless table-sm mb-0">
              <tbody>
                @foreach($order->items as $item)
                  <tr>
                    <td>{{ $item->menu?->name }}</td>
                    <td class="text-center">x{{ $item->quantity }}</td>
                    <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="border-top mt-3 pt-3">
            <div class="row">
              <div class="col-6">
                <strong>Total:</strong>
              </div>
              <div class="col-6 text-end">
                <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
              </div>
            </div>
          </div>

          @if($order->payment_method)
            <div class="mt-3">
              <small class="text-muted">
                <i class="mdi mdi-check-circle text-success"></i>
                Pembayaran via <strong>{{ ucfirst($order->payment_method) }}</strong>
              </small>
            </div>
          @endif
        </div>
      </div>

      <!-- Refresh Button -->
      <div class="mt-4 text-center">
        <a href="{{ route('orders.tracking', ['orderId' => $order->id]) }}" class="btn btn-outline-primary">
          <i class="mdi mdi-refresh"></i> Refresh
        </a>
      </div>
    </div>

  <style>
    .timeline {
      position: relative;
      padding: 0;
    }

    .timeline-item {
      display: flex;
      margin-bottom: 2rem;
      position: relative;
    }

    .timeline-item:not(:last-child)::before {
      content: '';
      position: absolute;
      left: 11px;
      top: 50px;
      width: 2px;
      height: 40px;
      background: #dee2e6;
    }

    .timeline-item.completed::before {
      background: #28a745;
    }

    .timeline-marker {
      width: 24px;
      height: 24px;
      border-radius: 50%;
      flex-shrink: 0;
      margin-right: 1rem;
      margin-top: 0.25rem;
    }

    .timeline-content {
      flex: 1;
    }

    .timeline-content h6 {
      font-size: 0.95rem;
      margin-bottom: 0.25rem;
    }
  </style>
@endsection
