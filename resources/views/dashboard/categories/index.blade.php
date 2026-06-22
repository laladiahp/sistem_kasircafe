@extends('dashboard.master')

@section('content')
  <div class="row mb-3">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h4 class="mb-0">Kelola Kategori</h4>
          <p class="text-muted mb-0">Atur kategori menu restoran Anda</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
          <i class="mdi mdi-plus"></i> Tambah Kategori
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

      <div class="card">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Slug</th>
                <th>Dibuat</th>
                <th style="width: 150px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($categories as $category)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>
                    <h6 class="mb-0">{{ $category->name }}</h6>
                  </td>
                  <td><code>{{ $category->slug }}</code></td>
                  <td><small class="text-muted">{{ $category->created_at->format('d M Y') }}</small></td>
                  <td>
                    <div class="btn-group btn-group-sm" role="group">
                      <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline-warning" title="Edit">
                        <i class="mdi mdi-pencil"></i> Edit
                      </a>
                      <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-outline-danger" title="Hapus" onclick="return confirm('Hapus kategori ini?')">
                          <i class="mdi mdi-trash-can"></i> Hapus
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center py-4 text-muted">
                    <i class="mdi mdi-inbox-multiple" style="font-size: 2rem;"></i>
                    <p class="mt-2">Belum ada kategori. Silakan tambahkan kategori baru.</p>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
