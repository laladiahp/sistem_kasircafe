@extends('dashboard.master')

@section('content')
  <div class="row mb-3">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h4 class="mb-0">Tambah Pesanan Kasir</h4>
          <p class="text-muted mb-0">Input pesanan langsung dari kasir untuk layanan meja atau take away.</p>
        </div>
        <div>
          <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
            <i class="mdi mdi-arrow-left"></i> Kembali ke Daftar Pesanan
          </a>
        </div>
      </div>
    </div>
  </div>

  @if($errors->any())
    <div class="row mb-3">
      <div class="col-12">
        <div class="alert alert-danger">
          <strong>Terjadi kesalahan:</strong>
          <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  @endif

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form method="POST" action="{{ route('admin.orders.store') }}">
            @csrf

            <div class="row mb-4">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">Pilih Meja</label>
                  <select name="table_id" class="form-select">
                    <option value="">-- Pilih Meja --</option>
                    @foreach($tables as $table)
                      <option value="{{ $table->id }}" {{ old('table_id') == $table->id ? 'selected' : '' }}>
                        {{ $table->number }} {{ $table->label ? ' - ' . $table->label : '' }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">Nama Pelanggan (Opsional)</label>
                  <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}" placeholder="Contoh: Budi">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">Catatan Pesanan (Opsional)</label>
                  <input type="text" name="notes" class="form-control" value="{{ old('notes') }}" placeholder="Contoh: Kurangi gula">
                </div>
              </div>
            </div>

            <h5 class="mb-3">Pilih Menu</h5>
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead class="table-light">
                  <tr>
                    <th style="width: 35%;">Menu</th>
                    <th style="width: 25%;">Kategori</th>
                    <th class="text-end" style="width: 20%;">Harga</th>
                    <th class="text-center" style="width: 20%;">Jumlah</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($menus as $menu)
                    <tr>
                      <td>
                        <div class="d-flex align-items-center gap-3">
                          @if($menu->image)
                            <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;">
                          @else
                            <div style="width: 60px; height: 60px; background: #e9ecef; border-radius: 6px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                              <i class="mdi mdi-image-off" style="color: #999; font-size: 1.5rem;"></i>
                            </div>
                          @endif
                          <div>
                            <h6 class="mb-0">{{ $menu->name }}</h6>
                            <small class="text-muted">{{ $menu->description ?? 'Deskripsi tidak tersedia' }}</small>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="badge bg-light text-dark">{{ $menu->category?->name ?? '-' }}</span>
                      </td>
                      <td class="text-end">
                        <strong>Rp {{ number_format($menu->price, 0, ',', '.') }}</strong>
                      </td>
                      <td class="text-center">
                        <input type="hidden" name="items[{{ $menu->id }}][menu_id]" value="{{ $menu->id }}">

                        <div class="d-flex justify-content-center">
                          <div class="input-group input-group-sm" style="width:140px;">
                            <button type="button" class="btn btn-outline-secondary btn-decrease" data-menu-id="{{ $menu->id }}">-</button>
                            <input type="text" readonly class="form-control text-center quantity-display" data-menu-id="{{ $menu->id }}" value="{{ old('items.' . $menu->id . '.quantity', 0) }}" style="max-width:60px;">
                            <button type="button" class="btn btn-outline-secondary btn-increase" data-menu-id="{{ $menu->id }}">+</button>
                          </div>
                        </div>

                        <input type="hidden" name="items[{{ $menu->id }}][quantity]" value="{{ old('items.' . $menu->id . '.quantity', 0) }}" class="quantity-hidden" data-menu-id="{{ $menu->id }}" min="0" max="99">
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="4" class="text-center py-4 text-muted">
                        <i class="mdi mdi-inbox-multiple" style="font-size: 2rem;"></i>
                        <p class="mt-2 mb-0">Belum ada menu tersedia.</p>
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <div class="mt-4 d-flex gap-2">
              <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                <i class="mdi mdi-check"></i> Simpan Pesanan Kasir
              </button>
              <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-lg">
                <i class="mdi mdi-close"></i> Batal
              </a>
            </div>

            <script>
              document.addEventListener('DOMContentLoaded', function () {
                function updateQuantity(menuId, delta) {
                  const display = document.querySelector('.quantity-display[data-menu-id="' + menuId + '"]');
                  const hidden = document.querySelector('.quantity-hidden[data-menu-id="' + menuId + '"]');
                  if (!display || !hidden) return;

                  const min = parseInt(hidden.getAttribute('min') || 0, 10);
                  const max = parseInt(hidden.getAttribute('max') || 99, 10);
                  let value = parseInt(hidden.value || 0, 10);
                  value = Math.min(max, Math.max(min, value + delta));
                  hidden.value = value;
                  display.value = value;
                }

                document.querySelectorAll('.btn-increase').forEach(function (btn) {
                  btn.addEventListener('click', function () {
                    updateQuantity(this.dataset.menuId, 1);
                  });
                });

                document.querySelectorAll('.btn-decrease').forEach(function (btn) {
                  btn.addEventListener('click', function () {
                    updateQuantity(this.dataset.menuId, -1);
                  });
                });
              });
            </script>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
