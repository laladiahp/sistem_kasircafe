@extends('layouts.customer')

@section('title', 'Konfirmasi Pesanan')

@section('content')
  <div class="card shadow-sm border-0">
        <div class="card-body">
          <h4 class="card-title mb-1">Konfirmasi Pesanan</h4>
          <p class="card-description mb-4">Silakan periksa kembali pesanan Anda sebelum melanjutkan</p>

          <div class="alert alert-info">
            <i class="mdi mdi-information"></i>
            <strong>Meja {{ $table->number }}</strong> {{ $table->label ? '(' . $table->label . ')' : '' }}
          </div>

          @if($customer_name)
            <div class="mb-3">
              <p class="mb-0"><strong>Nama:</strong> {{ $customer_name }}</p>
            </div>
          @endif

          @if($notes)
            <div class="mb-3">
              <p class="mb-0"><strong>Catatan:</strong> {{ $notes }}</p>
            </div>
          @endif

          <h5 class="mt-4 mb-3">Detail Pesanan</h5>
          <div class="table-responsive">
            <table class="table table-bordered mb-0">
              <thead class="table-light">
                <tr>
                  <th>Menu</th>
                  <th class="text-center">Qty</th>
                  <th class="text-end">Harga</th>
                  <th class="text-end">Subtotal</th>
                </tr>
              </thead>
              <tbody>
                @foreach($items as $item)
                  <tr>
                    <td>
                      <div>
                        <h6 class="mb-0">{{ $item['menu']->name }}</h6>
                        <small class="text-muted">{{ $item['menu']->category?->name ?? '-' }}</small>
                      </div>
                    </td>
                    <td class="text-center">{{ $item['quantity'] }}</td>
                    <td class="text-end">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                    <td class="text-end">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="border-top mt-4 pt-3">
            <div class="row">
              <div class="col-md-6">
                <p class="mb-0"><strong>Total Pesanan:</strong></p>
              </div>
              <div class="col-md-6 text-end">
                <h5 class="mb-0">Rp {{ number_format($total, 0, ',', '.') }}</h5>
              </div>
            </div>
          </div>

          <div class="mt-4 d-flex gap-2">
            <form action="{{ route('orders.submit', ['tableNumber' => $tableNumber]) }}" method="POST" class="flex-grow-1">
              @csrf
              <input type="hidden" name="customer_name" value="{{ $customer_name }}">
              <input type="hidden" name="notes" value="{{ $notes }}">
              <input type="hidden" name="total" value="{{ $total }}">
              <input type="hidden" name="items" value="{{ json_encode(array_map(fn($i) => ['menu_id' => $i['menu']->id, 'quantity' => $i['quantity'], 'price' => $i['price'], 'subtotal' => $i['subtotal']], $items)) }}">
              <button type="submit" class="btn btn-primary btn-lg w-100">
                <i class="mdi mdi-check-circle"></i> Lanjut ke Pembayaran
              </button>
            </form>
            <a href="{{ route('orders.table', ['tableNumber' => $tableNumber]) }}" class="btn btn-secondary btn-lg">
              <i class="mdi mdi-arrow-left"></i> Edit
            </a>
          </div>
        </div>
      </div>
    </div>
@endsection
