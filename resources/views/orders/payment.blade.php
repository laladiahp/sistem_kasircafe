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
              <div class="table-responsive mb-3">
                <table class="table table-borderless table-sm mb-0">
                  <tbody>
                    @foreach($order->items as $item)
                      <tr>
                        <td class="text-truncate" style="max-width: 280px;">{{ $item->menu?->name }} <span class="text-muted">(x{{ $item->quantity }})</span></td>
                        <td class="text-end fw-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                <span class="text-muted">Total Pembayaran</span>
                <span class="fs-5 fw-bold text-success">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
              </div>
            </div>
          </div>

          <form action="{{ route('orders.process-payment', ['orderId' => $order->id]) }}" method="POST">
            @csrf

            <div class="card border mb-4">
              <div class="card-body">
                <h6 class="card-title mb-3">Pilih Metode Pembayaran</h6>
                <div class="row g-3">
                  <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-check h-100">
                      <input class="form-check-input payment-method visually-hidden" type="radio" name="payment_method" id="gopay" value="gopay" required>
                      <label class="form-check-label w-100 h-100" for="gopay">
                        <div class="card border text-center py-4 h-100 payment-option-card">
                          <i class="mdi mdi-wallet-giftcard" style="font-size: 2rem; color: #00A699;"></i>
                          <div class="small mt-3"><strong>GoPay</strong></div>
                        </div>
                      </label>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-check h-100">
                      <input class="form-check-input payment-method visually-hidden" type="radio" name="payment_method" id="dana" value="dana" required>
                      <label class="form-check-label w-100 h-100" for="dana">
                        <div class="card border text-center py-4 h-100 payment-option-card">
                          <i class="mdi mdi-wallet-giftcard" style="font-size: 2rem; color: #3E54F3;"></i>
                          <div class="small mt-3"><strong>Dana</strong></div>
                        </div>
                      </label>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-check h-100">
                      <input class="form-check-input payment-method visually-hidden" type="radio" name="payment_method" id="cash" value="cash" required>
                      <label class="form-check-label w-100 h-100" for="cash">
                        <div class="card border text-center py-4 h-100 payment-option-card">
                          <i class="mdi mdi-cash" style="font-size: 2rem; color: #28A745;"></i>
                          <div class="small mt-3"><strong>Cash</strong></div>
                        </div>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div id="payment-qr" class="card border mb-4 shadow-sm">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3 flex-column flex-md-row">
                  <div>
                    <h6 class="mb-1">Scan kode QR untuk pembayaran</h6>
                    <p class="mb-0 text-muted">Bayar via <strong id="selected-method-label">Pilih Metode</strong></p>
                  </div>
                  <span class="badge bg-secondary mt-3 mt-md-0" id="selected-method-badge">Belum dipilih</span>
                </div>
                <div class="row g-3 align-items-center">
                  <div class="col-12 col-md-5 text-center">
                    <img id="payment-qr-image" src="https://via.placeholder.com/250x250?text=Pilih+Metode" alt="QR Code Pembayaran" class="img-fluid rounded shadow-sm">
                  </div>
                  <div class="col-12 col-md-7">
                    <div class="row g-2">
                      <div class="col-12">
                        <p class="mb-1 text-muted"><strong>ID Akun</strong></p>
                        <p id="payment-account" class="mb-3 fs-6 fw-semibold">-</p>
                      </div>
                      <div class="col-12">
                        <p class="mb-1 text-muted"><strong>Nama Penerima</strong></p>
                        <p id="payment-name" class="mb-0 fs-6 fw-semibold">-</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card border mb-4">
              <div class="card-body">
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
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-success btn-lg">
                <i class="mdi mdi-check-circle"></i> Konfirmasi Pembayaran
              </button>
            </div>
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

  const cardChange = (input) => {
    document.querySelectorAll('.payment-option-card').forEach(card => {
      card.classList.remove('payment-option-selected');
    });
    const selectedCard = input.closest('.form-check').querySelector('.payment-option-card');
    if (selectedCard) {
      selectedCard.classList.add('payment-option-selected');
    }
  };

  document.querySelectorAll('.payment-method').forEach(el => {
    el.addEventListener('change', function() {
      cardChange(this);
    });
    if (el.checked) {
      cardChange(el);
    }
  });
</script>

<style>
  .payment-option-card {
    min-height: 150px;
    transition: transform .16s ease, border-color .16s ease, box-shadow .16s ease, background-color .16s ease;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: .75rem;
    padding: 1.25rem 1rem;
  }
  .payment-option-card:hover {
    transform: translateY(-2px);
    border-color: #198754;
    box-shadow: 0 12px 25px rgba(0, 0, 0, .06);
  }
  .payment-option-selected {
    border-color: #198754 !important;
    background-color: #f3fbf6 !important;
    box-shadow: 0 10px 28px rgba(25, 135, 84, .12);
  }
  .payment-method-label {
    cursor: pointer;
    display: block;
  }
  .payment-method-label .payment-option-card {
    width: 100%;
  }
  @media (max-width: 767.98px) {
    .payment-option-card {
      min-height: 140px;
    }
  }
</style>
@endsection
