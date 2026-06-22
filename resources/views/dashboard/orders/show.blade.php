@extends('dashboard.master')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h4 class="card-title">Detail Pesanan {{ $order->order_number }}</h4>
              <p class="text-muted">Meja {{ $order->table_number }}</p>
            </div>
            <div class="d-flex gap-2">
              @if($order->status === \App\Models\Order::STATUS_PAID)
                <a href="{{ route('admin.orders.receipt', $order) }}" class="btn btn-outline-secondary" target="_blank">
                  <i class="mdi mdi-printer"></i> Cetak Struk
                </a>
              @endif
              <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
          </div>

          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          <div class="row">
            <div class="col-lg-5 mb-4">
              <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                  <h5 class="card-title mb-3">Informasi Pesanan</h5>
                  <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item px-0 py-2"><strong>Order</strong>: {{ $order->order_number }}</li>
                    <li class="list-group-item px-0 py-2"><strong>Meja</strong>: {{ $order->table_number }}</li>
                    <li class="list-group-item px-0 py-2"><strong>Pelanggan</strong>: {{ $order->customer_name ?? 'Tamu' }}</li>
                    <li class="list-group-item px-0 py-2"><strong>Status</strong>: <span class="badge bg-{{ $order->status === \App\Models\Order::STATUS_PENDING ? 'danger' : ($order->status === \App\Models\Order::STATUS_PREPARING ? 'info' : ($order->status === \App\Models\Order::STATUS_SERVED ? 'primary' : ($order->status === \App\Models\Order::STATUS_PAID ? 'success' : 'secondary'))) }} text-white">{{ ucfirst($order->status) }}</span></li>
                    <li class="list-group-item px-0 py-2"><strong>Total</strong>: Rp {{ number_format($order->total, 0, ',', '.') }}</li>
                  </ul>

                  <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                      <label class="form-label">Perbarui Status</label>
                      <select name="status" class="form-control">
                        @foreach([\App\Models\Order::STATUS_PENDING, \App\Models\Order::STATUS_PREPARING, \App\Models\Order::STATUS_SERVED, \App\Models\Order::STATUS_PAID, \App\Models\Order::STATUS_CANCELLED] as $status)
                          <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                        @endforeach
                      </select>
                    </div>
                    <button class="btn btn-primary w-100">Perbarui Status</button>
                  </form>
                </div>
              </div>

              <div class="card border-0 shadow-sm">
                <div class="card-body">
                  <h5 class="card-title mb-3">Informasi Pembayaran</h5>
                  <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item px-0 py-2"><strong>Metode</strong>: {{ $order->payment_method ? ucfirst($order->payment_method) : '-' }}</li>
                    <li class="list-group-item px-0 py-2"><strong>Bayar</strong>: Rp {{ number_format($order->paid_amount ?? 0, 0, ',', '.') }}</li>
                    <li class="list-group-item px-0 py-2"><strong>Kembalian</strong>: Rp {{ number_format($order->change_amount ?? 0, 0, ',', '.') }}</li>
                  </ul>

                  @if($order->status !== \App\Models\Order::STATUS_PAID && $order->status !== \App\Models\Order::STATUS_CANCELLED)
                    <form action="{{ route('admin.orders.pay', $order) }}" method="POST">
                      @csrf
                      <div class="form-group mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="payment_method" class="form-control @error('payment_method') is-invalid @enderror">
                          <option value="">Pilih metode</option>
                          <option value="cash" {{ old('payment_method', $order->payment_method) === 'cash' ? 'selected' : '' }}>Cash</option>
                          <option value="card" {{ old('payment_method', $order->payment_method) === 'card' ? 'selected' : '' }}>Card</option>
                          <option value="transfer" {{ old('payment_method', $order->payment_method) === 'transfer' ? 'selected' : '' }}>Transfer</option>
                        </select>
                        @error('payment_method')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label class="form-label">Jumlah Bayar</label>
                        <input type="number" id="paid-amount-input" name="paid_amount" class="form-control @error('paid_amount') is-invalid @enderror" value="{{ old('paid_amount', $order->total) }}" min="0" step="0.01">
                        @error('paid_amount')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="alert alert-info mb-3">
                        <div class="row">
                          <div class="col-6">
                            <p class="mb-1"><strong>Total Pesanan</strong></p>
                            <h5 class="text-success">Rp <span id="total-display">{{ number_format($order->total, 0, ',', '.') }}</span></h5>
                          </div>
                          <div class="col-6">
                            <p class="mb-1"><strong>Kembalian</strong></p>
                            <h5 class="text-primary">Rp <span id="change-display">0</span></h5>
                          </div>
                        </div>
                      </div>

                      <button class="btn btn-success w-100">Tandai Lunas</button>
                    </form>

                    <script>
                      const totalOrder = {{ $order->total }};
                      const paidInput = document.getElementById('paid-amount-input');
                      const changeDisplay = document.getElementById('change-display');

                      const updateChange = () => {
                        const paid = parseFloat(paidInput.value) || 0;
                        const change = Math.max(0, paid - totalOrder);
                        changeDisplay.textContent = new Intl.NumberFormat('id-ID').format(Math.floor(change));
                      };

                      paidInput.addEventListener('input', updateChange);
                      updateChange();
                    </script>
                  @endif
                </div>
              </div>
            </div>

            <div class="col-lg-7">
              <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                  <h5 class="card-title mb-3">Detail Item</h5>
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
                        @foreach($order->items as $item)
                          <tr>
                            <td>{{ $item->menu?->name ?? 'Menu terhapus' }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              @if($order->notes)
                <div class="card border-0 shadow-sm">
                  <div class="card-body">
                    <h5 class="card-title mb-3">Catatan Pesanan</h5>
                    <p class="mb-0">{{ $order->notes }}</p>
                  </div>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
