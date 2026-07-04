@extends('layouts.customer')

@section('title', 'Pesan Makanan - Meja ' . $table->number)

@section('content')
  <div class="card shadow-sm border-0">
        <div class="card-body">
          <div class="mb-4">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
              <i class="mdi mdi-information"></i>
              <strong>Selamat datang!</strong> Silakan pilih menu yang Anda inginkan dari daftar di bawah, masukkan jumlah, lalu kirim pesanan Anda.
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          </div>

          <h4 class="card-title mb-1">Pesanan untuk Meja {{ $table->number }}</h4>
          <p class="card-description mb-4">{{ $table->label ?? 'Pilih menu dan kirim pesanan Anda.' }}</p>

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

            <h5 class="mb-3">Daftar Menu</h5>
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead class="table-light">
                  <tr>
                    <th style="width: 40%;">Menu</th>
                    <th style="width: 25%;">Kategori</th>
                    <th class="text-end" style="width: 20%;">Harga</th>
                    <th class="text-center" style="width: 15%;">Jumlah</th>
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
                              <i class="mdi mdi-image-off" style="color: #999; font-size: 1.5rem;\"></i>
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
                        <p class="mt-2 mb-0">Belum ada menu tersedia saat ini.</p>
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <div class="mt-4 d-flex gap-2 flex-wrap">
              <button type="submit" class="btn btn-primary btn-lg flex-grow-1 d-flex align-items-center justify-content-center gap-2">
                <i class="mdi mdi-arrow-right-circle"></i> <span>Lanjut ke Konfirmasi</span>
              </button>
              <a href="{{ route('orders.table', ['tableNumber' => $tableNumber]) }}" class="btn btn-secondary btn-lg d-flex align-items-center justify-content-center gap-2">
                <i class="mdi mdi-refresh"></i> <span>Refresh</span>
              </a>
            </div>

            <style>
              .quantity-input {
                width: 55px !important;
                margin: 0 auto !important;
              }

              .quantity-btn {
                width: 32px;
                height: 32px;
                padding: 0;
                display: inline-flex;
                align-items: center;
                justify-content: center;
              }

              @media (max-width: 575.98px) {
                .quantity-input {
                  width: 50px !important;
                  margin: 0 auto !important;
                }

                .table thead {
                  font-size: 0.85rem;
                }

                .table tbody {
                  font-size: 0.9rem;
                }
              }
            </style>

            <script>
              document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.btn-decrease, .btn-increase').forEach(function (button) {
                  button.addEventListener('click', function () {
                    const menuId = this.dataset.menuId;
                    const delta = this.classList.contains('btn-increase') ? 1 : -1;
                    const display = document.querySelector('.quantity-display[data-menu-id="' + menuId + '"]');
                    const hidden = document.querySelector('.quantity-hidden[data-menu-id="' + menuId + '"]');

                    if (!display || !hidden) {
                      return;
                    }

                    let current = parseInt(display.value || hidden.value || 0, 10);
                    current = Math.min(99, Math.max(0, current + delta));
                    display.value = current;
                    hidden.value = current;
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
