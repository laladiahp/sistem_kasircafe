@extends('dashboard.master')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Ubah Menu</h4>
          <form action="{{ route('admin.menus.update', $menu) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
              <label>Nama Menu</label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $menu->name) }}">
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group mt-3">
              <label>Kategori</label>
              <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                <option value="">Pilih kategori</option>
                @foreach($categories as $category)
                  <option value="{{ $category->id }}" {{ old('category_id', $menu->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
              </select>
              @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group mt-3">
              <label>Harga</label>
              <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $menu->price) }}" step="0.01">
              @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group mt-3">
              <label>Stok</label>
              <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $menu->stock) }}" step="1" min="0">
              @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group mt-3">
              <label>Deskripsi</label>
              <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $menu->description) }}</textarea>
              @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group mt-3">
              <label>Foto Menu</label>
              @if($menu->image)
                <div class="mb-2">
                  <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="img-thumbnail" style="max-width: 200px;">
                </div>
              @endif
              <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
              <small class="text-muted">Format: JPG, PNG, GIF (Max: 2MB) | Biarkan kosong jika tidak ingin mengubah gambar</small>
              @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group mt-3">
              <label>Status</label>
              <select name="status" class="form-control @error('status') is-invalid @enderror">
                <option value="active" {{ old('status', $menu->status) === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $menu->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
              </select>
              @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <button type="submit" class="btn btn-success mt-3">Simpan</button>
            <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary mt-3">Kembali</a>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
