@extends('dashboard.master')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-4">Tambah Menu</h4>
          <form action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-12 col-md-6">
                <div class="form-group mb-3">
                  <label class="form-label fw-5">Nama Menu</label>
                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                  @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="form-group mb-3">
                  <label class="form-label fw-5">Kategori</label>
                  <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                    <option value="">Pilih kategori</option>
                    @foreach($categories as $category)
                      <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                  </select>
                  @error('category_id')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6">
                <div class="form-group mb-3">
                  <label class="form-label fw-5">Harga</label>
                  <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', 0) }}" step="0.01">
                  @error('price')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="form-group mb-3">
                  <label class="form-label fw-5">Stok</label>
                  <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', 0) }}" step="1" min="0">
                  @error('stock')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="form-group mb-3">
              <label class="form-label fw-5">Deskripsi</label>
              <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
              @error('description')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group mb-3">
              <label class="form-label fw-5">Foto Menu</label>
              <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
              <small class="text-muted d-block mt-1">Format: JPG, PNG, GIF (Max: 2MB)</small>
              @error('image')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group mb-4">
              <label class="form-label fw-5">Status</label>
              <select name="status" class="form-control @error('status') is-invalid @enderror">
                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
              </select>
              @error('status')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="d-flex gap-2 flex-wrap">
              <button type="submit" class="btn btn-success btn-lg flex-grow-1 d-flex align-items-center justify-content-center gap-2">
                <i class="mdi mdi-check"></i> <span>Simpan</span>
              </button>
              <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary btn-lg d-flex align-items-center justify-content-center gap-2">
                <i class="mdi mdi-arrow-left"></i> <span>Kembali</span>
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
