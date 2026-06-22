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
                        <input
                          type="number"
                          name="items[{{ $menu->id }}][quantity]"
                          class="form-control form-control-sm text-center"
                          value="{{ old('items.' . $menu->id . '.quantity', 0) }}"
                          min="0"
                          max="99"
                          style="width: 70px; margin: 0 auto;">
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
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
