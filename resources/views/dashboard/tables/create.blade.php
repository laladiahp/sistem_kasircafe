@extends('dashboard.master')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Tambah Meja</h4>
          <form action="{{ route('admin.tables.store') }}" method="POST">
            @csrf
            <div class="form-group">
              <label>Nomor Meja</label>
              <input type="text" name="number" class="form-control @error('number') is-invalid @enderror" value="{{ old('number') }}">
              @error('number')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group mt-3">
              <label>Label Meja</label>
              <input type="text" name="label" class="form-control @error('label') is-invalid @enderror" value="{{ old('label') }}">
              @error('label')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <button type="submit" class="btn btn-success mt-3">Simpan</button>
            <a href="{{ route('admin.tables.index') }}" class="btn btn-secondary mt-3">Kembali</a>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
