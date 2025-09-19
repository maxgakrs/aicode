@extends('layouts.app')

@section('title', 'แดชบอร์ดผู้ดูแลระบบ - ระบบร้านเช่าชุด')

@section('content')
<div class="row">
    <div class="col-12">
        <h2><i class="fas fa-tachometer-alt me-2"></i>แดชบอร์ดผู้ดูแลระบบ</h2>
        <p class="text-muted">ยินดีต้อนรับ {{ Auth::user()->name }}</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $totalCostumes }}</h4>
                        <p class="mb-0">ชุดทั้งหมด</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-tshirt fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $availableCostumes }}</h4>
                        <p class="mb-0">ชุดพร้อมให้เช่า</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $totalBookings }}</h4>
                        <p class="mb-0">การจองทั้งหมด</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar-check fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $pendingBookings }}</h4>
                        <p class="mb-0">รอยืนยัน</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-bolt me-2"></i>การดำเนินการด่วน</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.costumes.create') }}" class="btn btn-primary w-100">
                            <i class="fas fa-plus me-2"></i>เพิ่มชุดใหม่
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.costumes.index') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-list me-2"></i>จัดการชุด
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('bookings.index', ['status' => 'pending']) }}" class="btn btn-outline-warning w-100">
                            <i class="fas fa-clock me-2"></i>การจองรอยืนยัน
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('bookings.index') }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-calendar-alt me-2"></i>การจองทั้งหมด
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Bookings -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i>การจองล่าสุด</h5>
                <a href="{{ route('bookings.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-eye me-1"></i>ดูทั้งหมด
                </a>
            </div>
            <div class="card-body">
                @if($recentBookings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ลูกค้า</th>
                                <th>ชุด</th>
                                <th>วันที่เช่า</th>
                                <th>ยอดรวม</th>
                                <th>สถานะ</th>
                                <th>การชำระเงิน</th>
                                <th>การดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentBookings as $booking)
                            <tr>
                                <td>#{{ $booking->id }}</td>
                                <td>
                                    <div>
                                        <div class="fw-bold">{{ $booking->user->name }}</div>
                                        <small class="text-muted">{{ $booking->user->email }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($booking->costume->image)
                                        <img src="{{ asset('storage/' . $booking->costume->image) }}" 
                                             class="rounded me-2" width="30" height="30" style="object-fit: cover;">
                                        @else
                                        <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" 
                                             style="width: 30px; height: 30px;">
                                            <i class="fas fa-image text-muted" style="font-size: 0.8rem;"></i>
                                        </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold">{{ $booking->costume->name }}</div>
                                            <small class="text-muted">{{ $booking->costume->category }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>{{ $booking->rental_start_date->format('d/m/Y') }}</div>
                                    <small class="text-muted">ถึง {{ $booking->rental_end_date->format('d/m/Y') }}</small>
                                </td>
                                <td class="fw-bold text-primary">฿{{ number_format($booking->total_amount) }}</td>
                                <td>
                                    <span class="badge bg-{{ $booking->status == 'pending' ? 'warning' : ($booking->status == 'confirmed' ? 'success' : ($booking->status == 'completed' ? 'info' : 'danger')) }}">
                                        {{ $booking->status == 'pending' ? 'รอยืนยัน' : ($booking->status == 'confirmed' ? 'ยืนยันแล้ว' : ($booking->status == 'completed' ? 'เสร็จสิ้น' : 'ยกเลิก')) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $booking->payment_status == 'verified' ? 'success' : ($booking->payment_status == 'rejected' ? 'danger' : 'warning') }}">
                                        {{ $booking->payment_status == 'verified' ? 'ยืนยันแล้ว' : ($booking->payment_status == 'rejected' ? 'ปฏิเสธ' : 'รอยืนยัน') }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($booking->status == 'pending')
                                    <form method="POST" action="{{ route('admin.bookings.confirm', $booking) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" title="ยืนยัน">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.bookings.reject', $booking) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" title="ปฏิเสธ" onclick="return confirm('คุณแน่ใจหรือไม่ที่จะปฏิเสธการจองนี้?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                    @elseif($booking->status == 'confirmed')
                                    <form method="POST" action="{{ route('admin.bookings.complete', $booking) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-info" title="เสร็จสิ้น">
                                            <i class="fas fa-check-double"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">ยังไม่มีการจอง</h5>
                    <p class="text-muted">รอการจองจากลูกค้า</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
