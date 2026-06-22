@extends('dashboard.master')

@section('content')
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body text-center">
          <h3>Terima kasih!</h3>
          <p>Pesanan meja <strong>{{ $tableNumber }}</strong> sudah diterima.</p>
          <p>Silakan tunggu konfirmasi dari staf kami.</p>
          <a href="{{ route('orders.table', ['tableNumber' => $tableNumber]) }}" class="btn btn-secondary">Kembali ke daftar menu</a>
        </div>
      </div>
    </div>
  </div>
@endsection
