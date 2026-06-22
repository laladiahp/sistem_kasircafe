@extends('dashboard.master')

@section('content')
  <div class="row mb-4">
    <div class="col-12">
      <h2 class="mb-1">Selamat datang di Dashboard Admin</h2>
      <p class="text-muted mb-0">Kelola semua aspek resto Anda dari sini</p>
    </div>
  </div>

  <!-- Stat Cards -->
  <div class="row">
    <!-- Categories Card -->
    <div class="col-md-6 col-lg-4 grid-margin stretch-card">
      <a href="{{ route('admin.categories.index') }}" class="card stat-card" style="text-decoration: none;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted mb-1">Kategori</p>
              <h3 class="mb-0">{{ $categoriesCount }}</h3>
            </div>
            <div class="stat-icon bg-primary rounded-circle p-3">
              <i class="mdi mdi-shape text-white" style="font-size: 24px;"></i>
            </div>
          </div>
          <small class="text-muted">Klik untuk mengelola kategori</small>
        </div>
      </a>
    </div>

    <!-- Menus Card -->
    <div class="col-md-6 col-lg-4 grid-margin stretch-card">
      <a href="{{ route('admin.menus.index') }}" class="card stat-card" style="text-decoration: none;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted mb-1">Menu</p>
              <h3 class="mb-0">{{ $menusCount }}</h3>
            </div>
            <div class="stat-icon bg-success rounded-circle p-3">
              <i class="mdi mdi-silverware-fork-knife text-white" style="font-size: 24px;"></i>
            </div>
          </div>
          <small class="text-muted">Klik untuk mengelola menu</small>
        </div>
      </a>
    </div>

    <!-- Total Orders Card -->
    <div class="col-md-6 col-lg-4 grid-margin stretch-card">
      <a href="{{ route('admin.orders.index') }}" class="card stat-card" style="text-decoration: none;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted mb-1">Total Pesanan</p>
              <h3 class="mb-0">{{ $ordersCount }}</h3>
            </div>
            <div class="stat-icon bg-info rounded-circle p-3">
              <i class="mdi mdi-clipboard-list text-white" style="font-size: 24px;"></i>
            </div>
          </div>
          <small class="text-muted">Klik untuk melihat semua pesanan</small>
        </div>
      </a>
    </div>

    <!-- Tables Card -->
    <div class="col-md-6 col-lg-4 grid-margin stretch-card">
      <a href="{{ route('admin.tables.index') }}" class="card stat-card" style="text-decoration: none;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted mb-1">Meja</p>
              <h3 class="mb-0">{{ $tablesCount }}</h3>
            </div>
            <div class="stat-icon bg-warning rounded-circle p-3">
              <i class="mdi mdi-table text-white" style="font-size: 24px;"></i>
            </div>
          </div>
          <small class="text-muted">Klik untuk mengelola meja</small>
        </div>
      </a>
    </div>

    <!-- Pending Orders Card -->
    <div class="col-md-6 col-lg-4 grid-margin stretch-card">
      <a href="{{ route('admin.orders.index') }}" class="card stat-card" style="text-decoration: none;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted mb-1">Pesanan Pending</p>
              <h3 class="mb-0 @if($pendingOrders > 0) text-danger @endif">{{ $pendingOrders }}</h3>
            </div>
            <div class="stat-icon @if($pendingOrders > 0) bg-danger @else bg-secondary @endif rounded-circle p-3">
              <i class="mdi mdi-clock-outline text-white" style="font-size: 24px;"></i>
            </div>
          </div>
          <small class="text-muted">Segera proses pesanan yang menunggu</small>
        </div>
      </a>
    </div>

    <!-- Sales Card -->
    <div class="col-md-6 col-lg-4 grid-margin stretch-card">
      <a href="{{ route('admin.reports.index') }}" class="card stat-card" style="text-decoration: none;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="text-muted mb-1">Penjualan Terkonfirmasi</p>
              <h3 class="mb-0">Rp {{ number_format($totalSales, 0, ',', '.') }}</h3>
            </div>
            <div class="stat-icon bg-success rounded-circle p-3">
              <i class="mdi mdi-cash-multiple text-white" style="font-size: 24px;"></i>
            </div>
          </div>
          <small class="text-muted">Klik untuk melihat laporan detail</small>
        </div>
      </a>
    </div>
  </div>

  <!-- Additional Info -->
  <div class="row mt-4">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title mb-3">Akses Cepat</h5>
          <div class="row">
            <div class="col-md-3 col-sm-6 mb-3">
              <a href="{{ route('admin.menus.create') }}" class="btn btn-outline-primary btn-block w-100">
                <i class="mdi mdi-plus"></i> Tambah Menu Baru
              </a>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
              <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-info btn-block w-100">
                <i class="mdi mdi-plus"></i> Tambah Kategori
              </a>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
              <a href="{{ route('admin.tables.create') }}" class="btn btn-outline-warning btn-block w-100">
                <i class="mdi mdi-plus"></i> Tambah Meja
              </a>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
              <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-danger btn-block w-100">
                <i class="mdi mdi-list"></i> Lihat Pesanan
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    .stat-card {
      border: 1px solid #f0f0f0;
      transition: all 0.3s ease;
      color: inherit;
    }
    .stat-card:hover {
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      transform: translateY(-2px);
    }
    .stat-icon {
      width: 60px;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .btn-block {
      width: 100% !important;
    }
  </style>
@endsection
