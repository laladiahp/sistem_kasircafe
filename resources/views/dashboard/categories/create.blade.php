@extends('dashboard.master')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Tambah Kategori</h4>
          <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
              <label>Nama Kategori</label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <button type="submit" class="btn btn-success mt-3">Simpan</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary mt-3">Kembali</a>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
