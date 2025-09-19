@extends('layouts.app')

@section('title', 'การจองของฉัน - ระบบร้านเช่าชุด')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-calendar-check me-2"></i>การจองของฉัน</h2>
            <a href="{{ route('costumes.index') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>จองชุดใหม่
            </a>
        </div>

        <!-- Filter Section -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('bookings.index') }}">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="status" class="form-label">สถานะการจอง</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">ทั้งหมด</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>รอยืนยัน</option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>ยืนยันแล้ว</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>เสร็จสิ้น</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ยกเลิก</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bookings Table -->
        @if($bookings->count() > 0)
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
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
                            @foreach($bookings as $booking)
                            <tr>
                                <td>#{{ $booking->id }}</td>
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
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $bookings->appends(request()->query())->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-calendar-times fa-5x text-muted mb-3"></i>
            <h4 class="text-muted">ยังไม่มีการจอง</h4>
            <p class="text-muted">เริ่มต้นการจองชุดของคุณได้เลย</p>
            <a href="{{ route('costumes.index') }}" class="btn btn-primary">
                <i class="fas fa-search me-2"></i>ดูชุดทั้งหมด
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
