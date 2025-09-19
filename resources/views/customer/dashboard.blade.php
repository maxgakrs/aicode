@extends('layouts.app')

@section('title', 'แดชบอร์ด - ระบบร้านเช่าชุด')

@section('content')
<div class="row">
    <div class="col-12">
        <h2><i class="fas fa-tachometer-alt me-2"></i>แดชบอร์ด</h2>
        <p class="text-muted">ยินดีต้อนรับ {{ Auth::user()->name }}</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card bg-primary text-white">
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
    <div class="col-md-4 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $pendingBookings }}</h4>
                        <p class="mb-0">รอการยืนยัน</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $totalBookings - $pendingBookings }}</h4>
                        <p class="mb-0">การจองที่ยืนยันแล้ว</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
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
                @if($userBookings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ชุด</th>
                                <th>วันที่เช่า</th>
                                <th>จำนวนวัน</th>
                                <th>ยอดรวม</th>
                                <th>สถานะ</th>
                                <th>การชำระเงิน</th>
                                <th>การดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userBookings as $booking)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($booking->costume->image)
                                        <img src="{{ asset('storage/' . $booking->costume->image) }}" 
                                             class="rounded me-2" width="40" height="40" style="object-fit: cover;">
                                        @else
                                        <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" 
                                             style="width: 40px; height: 40px;">
                                            <i class="fas fa-image text-muted"></i>
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
                                <td>{{ $booking->total_days }} วัน</td>
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
                                    <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
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
                    <p class="text-muted">เริ่มต้นการจองชุดของคุณได้เลย</p>
                    <a href="{{ route('costumes.index') }}" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>ดูชุดทั้งหมด
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
