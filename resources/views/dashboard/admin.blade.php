@extends('dashboard.master')

@section('content')
  <div class="row mb-4">
    <div class="col-12">
      <div class="card border-0 shadow-sm p-3 p-md-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
          <div>
            <h2 class="mb-1 h4 h3-md">Selamat datang di Dashboard Admin</h2>
            <p class="text-muted mb-0">Kelola semua aspek resto Anda dari sini dengan cepat dan nyaman.</p>
          </div>
          <span class="badge bg-light text-dark px-3 py-2 rounded-pill">Mode Admin</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Stat Cards -->
  <div class="row g-3">
    <!-- Categories Card -->
    <div class="col-12 col-sm-6 col-xl-4 grid-margin stretch-card">
      <a href="{{ route('admin.categories.index') }}" class="card stat-card h-100 w-100" style="text-decoration: none;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start gap-3">
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
    <div class="col-12 col-sm-6 col-xl-4 grid-margin stretch-card">
      <a href="{{ route('admin.menus.index') }}" class="card stat-card h-100 w-100" style="text-decoration: none;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start gap-3">
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
    <div class="col-12 col-sm-6 col-xl-4 grid-margin stretch-card">
      <a href="{{ route('admin.orders.index') }}" class="card stat-card h-100 w-100" style="text-decoration: none;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start gap-3">
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
    <div class="col-12 col-sm-6 col-xl-4 grid-margin stretch-card">
      <a href="{{ route('admin.tables.index') }}" class="card stat-card h-100 w-100" style="text-decoration: none;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start gap-3">
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
    <div class="col-12 col-sm-6 col-xl-4 grid-margin stretch-card">
      <a href="{{ route('admin.orders.index') }}" class="card stat-card h-100 w-100" style="text-decoration: none;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start gap-3">
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
    <div class="col-12 col-sm-6 col-xl-4 grid-margin stretch-card">
      <a href="{{ route('admin.reports.index') }}" class="card stat-card h-100 w-100" style="text-decoration: none;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start gap-3">
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
          <div class="row g-2">
            <div class="col-12 col-sm-6 col-lg-3">
              <a href="{{ route('admin.menus.create') }}" class="btn btn-outline-primary btn-block w-100 d-flex align-items-center justify-content-center gap-2">
                <i class="mdi mdi-plus"></i> Tambah Menu Baru
              </a>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
              <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-info btn-block w-100 d-flex align-items-center justify-content-center gap-2">
                <i class="mdi mdi-plus"></i> Tambah Kategori
              </a>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
              <a href="{{ route('admin.tables.create') }}" class="btn btn-outline-warning btn-block w-100 d-flex align-items-center justify-content-center gap-2">
                <i class="mdi mdi-plus"></i> Tambah Meja
              </a>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
              <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-danger btn-block w-100 d-flex align-items-center justify-content-center gap-2">
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
      display: block;
    }
    .stat-card:hover {
      box-shadow: 0 8px 20px rgba(0,0,0,0.08);
      transform: translateY(-3px);
    }
    .stat-card .card-body {
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      height: 100%;
      gap: 0.75rem;
    }
    .stat-card h3 {
      font-size: clamp(1.2rem, 2vw, 1.6rem);
      line-height: 1.2;
    }
    .stat-icon {
      width: 52px;
      height: 52px;
      min-width: 52px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .btn-block {
      width: 100% !important;
    }

    @media (max-width: 576px) {
      .stat-card .card-body {
        padding: 1rem;
      }
      .stat-icon {
        width: 46px;
        height: 46px;
        min-width: 46px;
      }
      .stat-icon i {
        font-size: 20px !important;
      }
      .btn {
        padding: 0.7rem 0.8rem;
      }
    }
  </style>
@endsection
