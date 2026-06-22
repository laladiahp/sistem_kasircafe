@extends('layouts.customer')

@section('title', 'Pembayaran')

@section('content')
  <div class="card shadow-sm border-0">
        <div class="card-body">
          <h4 class="card-title mb-1">Pembayaran Pesanan</h4>
          <p class="card-description mb-4">Pesanan {{ $order->order_number }}</p>

          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="mdi mdi-clock"></i>
            <strong>Status:</strong> Menunggu Pembayaran
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>

          @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Terjadi kesalahan:</strong>
              <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          @endif

          <div class="card border mb-4">
            <div class="card-body">
              <h6 class="card-title mb-3">Ringkasan Pesanan</h6>
              <div class="table-responsive mb-0">
                <table class="table table-borderless table-sm mb-0">
                  <tbody>
                    @foreach($order->items as $item)
                      <tr>
                        <td>{{ $item->menu?->name }} (x{{ $item->quantity }})</td>
                        <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="border-top border-bottom py-3 mb-4">
            <div class="row align-items-center">
              <div class="col-6">
                <p class="mb-0"><strong>Total Pembayaran:</strong></p>
              </div>
              <div class="col-6 text-end">
                <h4 class="mb-0" style="color: #198754;">Rp {{ number_format($order->total, 0, ',', '.') }}</h4>
              </div>
            </div>
          </div>

          <form action="{{ route('orders.process-payment', ['orderId' => $order->id]) }}" method="POST">
            @csrf

            <div class="form-group mb-3">
              <label class="form-label">Pilih Metode Pembayaran</label>
              <div class="row g-2">
                <div class="col-6">
                  <div class="form-check">
                    <input class="form-check-input payment-method" type="radio" name="payment_method" id="gopay" value="gopay" required>
                    <label class="form-check-label w-100" for="gopay">
                      <div class="card border text-center py-3" style="cursor: pointer;">
                        <i class="mdi mdi-wallet-giftcard" style="font-size: 2rem; color: #00A699;"></i>
                        <div class="small mt-2"><strong>GoPay</strong></div>
                      </div>
                    </label>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-check">
                    <input class="form-check-input payment-method" type="radio" name="payment_method" id="dana" value="dana" required>
                    <label class="form-check-label w-100" for="dana">
                      <div class="card border text-center py-3" style="cursor: pointer;">
                        <i class="mdi mdi-wallet-giftcard" style="font-size: 2rem; color: #3E54F3;"></i>
                        <div class="small mt-2"><strong>Dana</strong></div>
                      </div>
                    </label>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-check">
                    <input class="form-check-input payment-method" type="radio" name="payment_method" id="cash" value="cash" required>
                    <label class="form-check-label w-100" for="cash">
                      <div class="card border text-center py-3" style="cursor: pointer;">
                        <i class="mdi mdi-cash" style="font-size: 2rem; color: #28A745;"></i>
                        <div class="small mt-2"><strong>Cash</strong></div>
                      </div>
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <div id="payment-qr" class="card p-3 mb-4">
              <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                  <h6 class="mb-1">Scan kode QR untuk pembayaran</h6>
                  <p class="mb-0 text-muted">Bayar via <strong id="selected-method-label">Pilih Metode</strong></p>
                </div>
                <span class="badge bg-secondary" id="selected-method-badge">Belum dipilih</span>
              </div>
              <div class="row align-items-center">
                <div class="col-md-4 text-center mb-3 mb-md-0">
                  <img id="payment-qr-image" src="https://via.placeholder.com/250x250?text=Pilih+Metode" alt="QR Code Pembayaran" class="img-fluid rounded">
                </div>
                <div class="col-md-3">
                  <p class="mb-1"><strong>ID Akun</strong></p>
                  <p id="payment-account" class="mb-2">-</p>
                  <p class="mb-1"><strong>Nama Penerima</strong></p>
                  <p id="payment-name" class="mb-0">-</p>
                </div>
              </div>
            </div>

            <div class="form-group mb-4">
              <label class="form-label">Jumlah Pembayaran</label>
              <div class="input-group input-group-lg">
                <span class="input-group-text">Rp</span>
                <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount', $order->total) }}" min="{{ $order->total }}" step="1" required>
              </div>
              <small class="text-muted d-block mt-2">
                Minimal: Rp {{ number_format($order->total, 0, ',', '.') }}
              </small>
              @error('amount')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>

            <button type="submit" class="btn btn-success btn-lg w-100">
              <i class="mdi mdi-check-circle"></i> Konfirmasi Pembayaran
            </button>
          </form>

          <div class="mt-3 text-center">
            <small class="text-muted">
              <i class="mdi mdi-lock"></i> Pembayaran Anda aman dan terenkripsi
            </small>
          </div>
        </div>
      </div>
    </div>

<script>
  const paymentData = {
  gopay: {
    label: 'GoPay',
    account: '083867114801',
    name: 'Café Kasir',
    qr: "{{ asset('asset/img/qris-gopay.jpeg') }}"
  },
  dana: {
    label: 'Dana',
    account: '083172099402',
    name: 'Café Kasir',
    qr: "{{ asset('asset/img/qris-dana.jpeg') }}"
  },
  cash: {
    label: 'Uang Tunai',
    account: '-',
    name: 'Hubungi Staff Kasir',
    isCash: true
  }
};

  const updatePaymentPreview = (method) => {
    const data = paymentData[method];
    if (!data) return;

    document.getElementById('selected-method-label').textContent = data.label;
    document.getElementById('selected-method-badge').textContent = data.label;
    
    if (data.isCash) {
      // Untuk cash, tampilkan instruksi khusus
      document.getElementById('selected-method-badge').classList.remove('bg-secondary', 'bg-success');
      document.getElementById('selected-method-badge').classList.add('bg-info');
      document.getElementById('payment-qr-image').src = 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 250 250"><rect fill="%23E8F4F8" width="250" height="250"/><text x="125" y="125" text-anchor="middle" dy=".3em" font-size="18" fill="%23007BFF" font-weight="bold">Hubungi Staff</text></svg>';
      document.getElementById('payment-account').textContent = 'Tunjukkan pesanan ke staff';
      document.getElementById('payment-name').textContent = 'Bayar langsung di kasir';
    } else {
      // Untuk e-wallet
      document.getElementById('selected-method-badge').classList.remove('bg-info');
      document.getElementById('selected-method-badge').classList.add('bg-success');
      document.getElementById('payment-account').textContent = data.account;
      document.getElementById('payment-name').textContent = data.name;
      document.getElementById('payment-qr-image').src = data.qr;
    }
    document.getElementById('payment-qr').classList.remove('d-none');
  };

  document.querySelectorAll('.payment-method').forEach(el => {
    el.addEventListener('change', function() {
      document.querySelectorAll('.form-check .card').forEach(card => {
        card.classList.remove('border-primary', 'bg-light');
      });
      this.closest('.form-check').querySelector('.card').classList.add('border-primary', 'bg-light');
      updatePaymentPreview(this.value);
    });
  });

  const checkedMethod = document.querySelector('.payment-method:checked');
  if (checkedMethod) {
    updatePaymentPreview(checkedMethod.value);
  } else {
    document.getElementById('selected-method-badge').classList.remove('bg-success');
    document.getElementById('selected-method-badge').classList.add('bg-secondary');
  }
</script>
@endsection
