@extends('dashboard.master')

@section('content')
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card shadow-sm border-0">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
              <h4 class="mb-1">Struk Pembayaran</h4>
              <p class="text-muted mb-0">Pesanan {{ $order->order_number }}</p>
            </div>
            <button type="button" class="btn btn-primary btn-sm" onclick="window.print();">
              <i class="mdi mdi-printer"></i> Cetak
            </button>
          </div>

          <div class="mb-3">
            <p class="mb-1"><strong>Meja:</strong> {{ $order->table_number }}</p>
            <p class="mb-1"><strong>Pelanggan:</strong> {{ $order->customer_name ?? 'Tamu' }}</p>
            <p class="mb-0"><strong>Status:</strong> Selesai</p>
          </div>

          <div class="table-responsive mb-3">
            <table class="table table-borderless table-sm mb-0">
              <thead>
                <tr>
                  <th>Menu</th>
                  <th class="text-center">Qty</th>
                  <th class="text-end">Subtotal</th>
                </tr>
              </thead>
              <tbody>
                @foreach($order->items as $item)
                  <tr>
                    <td>{{ $item->menu?->name ?? 'Menu terhapus' }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="border-top pt-3">
            <div class="d-flex justify-content-between mb-2">
              <span>Total</span>
              <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
            </div>
            <div class="d-flex justify-content-between mb-2">
              <span>Pembayaran</span>
              <strong>{{ ucfirst($order->payment_method ?? '-') }}</strong>
            </div>
            <div class="d-flex justify-content-between mb-2">
              <span>Dibayar</span>
              <strong>Rp {{ number_format($order->paid_amount ?? 0, 0, ',', '.') }}</strong>
            </div>
            <div class="d-flex justify-content-between mb-0">
              <span>Kembali</span>
              <strong>Rp {{ number_format($order->change_amount ?? 0, 0, ',', '.') }}</strong>
            </div>
          </div>

          @if($order->notes)
            <div class="mt-4">
              <p class="mb-1"><strong>Catatan:</strong></p>
              <p>{{ $order->notes }}</p>
            </div>
          @endif

          <div class="text-center text-muted mt-4">
            <small>Terima kasih atas kunjungan Anda.</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    @media print {
      body * {
        visibility: hidden;
      }
      .card, .card * {
        visibility: visible;
      }
      .card {
        width: 100%;
        box-shadow: none;
      }
      button {
        display: none !important;
      }
    }
  </style>
@endsection