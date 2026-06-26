@extends('dashboard.master')

@section('content')
  <div class="row mb-3">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h4 class="mb-0">Kelola Menu</h4>
          <p class="text-muted mb-0">Atur daftar menu dan harga produk</p>
        </div>
        <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">
          <i class="mdi mdi-plus"></i> Tambah Menu
        </a>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="mdi mdi-check-circle"></i> {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <div class="card shadow-sm border-0">
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
          <div>
            <h5 class="card-title mb-1">Daftar Menu</h5>
            <p class="text-muted mb-0">Lihat semua menu yang tersedia di restoran Anda.</p>
          </div>
        </div>

        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover table-striped mb-0 menu-table">
              <thead class="table-light">
                <tr>
                  <th style="width: 55px;">No</th>
                  <th>Nama Menu</th>
                  <th>Kategori</th>
                  <th>Harga</th>
                  <th>Stok</th>
                  <th>Status</th>
                  <th class="text-end" style="width: 175px;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($menus as $menu)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                      <div class="d-flex align-items-center gap-2">
                        @if($menu->image)
                          <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                          <div class="rounded" style="width: 50px; height: 50px; background: #e9ecef; display: flex; align-items: center; justify-content: center;">
                            <i class="mdi mdi-image-off text-muted"></i>
                          </div>
                        @endif
                        <div>
                          <h6 class="mb-1">{{ $menu->name }}</h6>
                          <small class="text-muted">{{ $menu->description ?? 'Tidak ada deskripsi' }}</small>
                        </div>
                      </div>
                    </td>
                    <td>
                      <span class="badge bg-light text-dark">{{ $menu->category?->name ?? '-' }}</span>
                    </td>
                    <td>
                      <strong>Rp {{ number_format($menu->price, 0, ',', '.') }}</strong>
                    </td>
                    <td>
                      <span class="badge bg-info text-dark">{{ $menu->stock }}</span>
                    </td>
                    <td>
                      @if($menu->status === 'active')
                        <span class="badge bg-success">
                          <i class="mdi mdi-check-circle-outline"></i> Aktif
                        </span>
                      @else
                        <span class="badge bg-secondary">
                          <i class="mdi mdi-block-helper"></i> Nonaktif
                        </span>
                      @endif
                    </td>
                    <td class="text-end">
                      <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-outline-warning btn-sm d-inline-flex align-items-center gap-1" title="Edit">
                          <i class="mdi mdi-pencil"></i><span class="d-none d-md-inline">Edit</span>
                        </a>
                        <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" class="d-inline">
                          @method('DELETE')
                          @csrf
                          <button class="btn btn-outline-danger btn-sm d-inline-flex align-items-center gap-1" title="Hapus" onclick="return confirm('Hapus menu ini?')">
                            <i class="mdi mdi-trash-can"></i><span class="d-none d-md-inline">Hapus</span>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                      <i class="mdi mdi-inbox-multiple" style="font-size: 2.4rem;"></i>
                      <p class="mt-3 mb-0">Belum ada menu. Silakan tambahkan menu baru.</p>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    .menu-table th,
    .menu-table td {
      vertical-align: middle;
    }
    .menu-table td h6 {
      font-size: 0.95rem;
    }
    .menu-table td small {
      font-size: 0.85rem;
    }
  </style>
@endsection
