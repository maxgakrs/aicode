@extends('layouts.app')

@section('title', 'รายละเอียดการจอง #' . $booking->id)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-calendar-check me-2"></i>รายละเอียดการจอง #{{ $booking->id }}</h4>
                <div>
                    <span class="badge bg-{{ $booking->status == 'pending' ? 'warning' : ($booking->status == 'confirmed' ? 'success' : ($booking->status == 'completed' ? 'info' : 'danger')) }} fs-6">
                        {{ $booking->status == 'pending' ? 'รอยืนยัน' : ($booking->status == 'confirmed' ? 'ยืนยันแล้ว' : ($booking->status == 'completed' ? 'เสร็จสิ้น' : 'ยกเลิก')) }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-user me-2"></i>ข้อมูลลูกค้า</h6>
                        <p><strong>ชื่อ:</strong> {{ $booking->user->name }}</p>
                        <p><strong>อีเมล:</strong> {{ $booking->user->email }}</p>
                        @if($booking->user->phone)
                        <p><strong>เบอร์โทร:</strong> {{ $booking->user->phone }}</p>
                        @endif
                        @if($booking->user->address)
                        <p><strong>ที่อยู่:</strong> {{ $booking->user->address }}</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-calendar me-2"></i>ข้อมูลการจอง</h6>
                        <p><strong>วันที่เริ่มเช่า:</strong> {{ $booking->rental_start_date->format('d/m/Y') }}</p>
                        <p><strong>วันที่สิ้นสุด:</strong> {{ $booking->rental_end_date->format('d/m/Y') }}</p>
                        <p><strong>จำนวนวัน:</strong> {{ $booking->total_days }} วัน</p>
                        <p><strong>ยอดรวม:</strong> <span class="h5 text-primary">฿{{ number_format($booking->total_amount) }}</span></p>
                    </div>
                </div>
                
                @if($booking->notes)
                <hr>
                <h6><i class="fas fa-sticky-note me-2"></i>หมายเหตุ</h6>
                <p class="text-muted">{{ $booking->notes }}</p>
                @endif
                
                <hr>
                <h6><i class="fas fa-tshirt me-2"></i>ข้อมูลชุด</h6>
                <div class="row">
                    <div class="col-md-4">
                        @if($booking->costume->image)
                        <img src="{{ asset('storage/' . $booking->costume->image) }}" class="img-fluid rounded" alt="{{ $booking->costume->name }}">
                        @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                            <i class="fas fa-image fa-2x text-muted"></i>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h5>{{ $booking->costume->name }}</h5>
                        <p class="text-muted">{{ $booking->costume->description }}</p>
                        <div class="mb-2">
                            @if($booking->costume->category)
                            <span class="badge bg-info me-1">{{ $booking->costume->category }}</span>
                            @endif
                            @if($booking->costume->size)
                            <span class="badge bg-secondary me-1">ขนาด: {{ $booking->costume->size }}</span>
                            @endif
                            @if($booking->costume->color)
                            <span class="badge bg-light text-dark me-1">สี: {{ $booking->costume->color }}</span>
                            @endif
                        </div>
                        <p><strong>ราคาต่อวัน:</strong> ฿{{ number_format($booking->costume->price_per_day) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Payment Status -->
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="fas fa-credit-card me-2"></i>สถานะการชำระเงิน</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <span class="badge bg-{{ $booking->payment_status == 'verified' ? 'success' : ($booking->payment_status == 'rejected' ? 'danger' : 'warning') }} fs-6">
                        {{ $booking->payment_status == 'verified' ? 'ยืนยันแล้ว' : ($booking->payment_status == 'rejected' ? 'ปฏิเสธ' : 'รอยืนยัน') }}
                    </span>
                </div>
                
                @if($booking->payment_slip)
                <div class="mb-3">
                    <h6>สลิปการโอนเงิน</h6>
                    <img src="{{ asset('storage/' . $booking->payment_slip) }}" class="img-fluid rounded border" alt="Payment Slip">
                </div>
                @endif
                
                @if($booking->payment_verified_at)
                <p class="text-muted small">
                    <i class="fas fa-check-circle me-1"></i>
                    ยืนยันเมื่อ: {{ $booking->payment_verified_at->format('d/m/Y H:i') }}
                </p>
                @endif
                
                @if($booking->status == 'pending' && !$booking->payment_slip && !Auth::user()->isAdmin())
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    กรุณาอัพโหลดสลิปการโอนเงินเพื่อยืนยันการจอง
                </div>
                @endif
            </div>
        </div>
        
        <!-- Actions -->
        <div class="card">
            <div class="card-header">
                <h6><i class="fas fa-cogs me-2"></i>การดำเนินการ</h6>
            </div>
            <div class="card-body">
                @if(Auth::user()->isAdmin())
                <!-- Admin Actions -->
                @if($booking->status == 'pending')
                <div class="d-grid gap-2 mb-3">
                    <form method="POST" action="{{ route('admin.bookings.confirm', $booking) }}">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-check me-2"></i>ยืนยันการจอง
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.bookings.reject', $booking) }}">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('คุณแน่ใจหรือไม่ที่จะปฏิเสธการจองนี้?')">
                            <i class="fas fa-times me-2"></i>ปฏิเสธการจอง
                        </button>
                    </form>
                </div>
                @elseif($booking->status == 'confirmed')
                <div class="d-grid gap-2 mb-3">
                    <form method="POST" action="{{ route('admin.bookings.complete', $booking) }}">
                        @csrf
                        <button type="submit" class="btn btn-info w-100">
                            <i class="fas fa-check-double me-2"></i>เสร็จสิ้นการจอง
                        </button>
                    </form>
                </div>
                @endif
                @else
                <!-- Customer Actions -->
                @if($booking->status == 'pending')
                <div class="d-grid gap-2 mb-3">
                    <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>แก้ไขการจอง
                    </a>
                    <form method="POST" action="{{ route('bookings.cancel', $booking) }}">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('คุณแน่ใจหรือไม่ที่จะยกเลิกการจองนี้?')">
                            <i class="fas fa-times me-2"></i>ยกเลิกการจอง
                        </button>
                    </form>
                </div>
                @endif
                
                @if($booking->status == 'pending' && !$booking->payment_slip)
                <div class="mb-3">
                    <h6>อัพโหลดสลิปการโอนเงิน</h6>
                    <form method="POST" action="{{ route('bookings.upload-payment', $booking) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-2">
                            <input type="file" class="form-control" name="payment_slip" accept="image/*" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-upload me-2"></i>อัพโหลดสลิป
                        </button>
                    </form>
                </div>
                @endif
                @endif
                
                <div class="d-grid">
                    <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>กลับไปรายการจอง
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
