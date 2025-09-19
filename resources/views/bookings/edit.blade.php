@extends('layouts.app')

@section('title', 'แก้ไขการจอง #' . $booking->id)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-edit me-2"></i>แก้ไขการจอง #{{ $booking->id }}</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('bookings.update', $booking) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="rental_start_date" class="form-label">วันที่เริ่มเช่า</label>
                            <input type="date" class="form-control @error('rental_start_date') is-invalid @enderror" 
                                   id="rental_start_date" name="rental_start_date" 
                                   value="{{ old('rental_start_date', $booking->rental_start_date->format('Y-m-d')) }}" 
                                   min="{{ date('Y-m-d') }}" required>
                            @error('rental_start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="rental_end_date" class="form-label">วันที่สิ้นสุดการเช่า</label>
                            <input type="date" class="form-control @error('rental_end_date') is-invalid @enderror" 
                                   id="rental_end_date" name="rental_end_date" 
                                   value="{{ old('rental_end_date', $booking->rental_end_date->format('Y-m-d')) }}" required>
                            @error('rental_end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">หมายเหตุ (ไม่บังคับ)</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="3" 
                                  placeholder="หมายเหตุเพิ่มเติม...">{{ old('notes', $booking->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('bookings.show', $booking) }}" class="btn btn-outline-secondary me-md-2">
                            <i class="fas fa-arrow-left me-2"></i>ย้อนกลับ
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>บันทึกการแก้ไข
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-info-circle me-2"></i>รายละเอียดการจอง</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6>ชุดที่จอง</h6>
                    <p class="fw-bold">{{ $booking->costume->name }}</p>
                    <p class="text-muted">{{ $booking->costume->description }}</p>
                </div>
                
                <div class="mb-3">
                    <h6>ราคาต่อวัน</h6>
                    <p class="h5 text-primary">฿{{ number_format($booking->costume->price_per_day) }}</p>
                </div>
                
                <div class="mb-3">
                    <h6>สถานะปัจจุบัน</h6>
                    <span class="badge bg-warning">รอยืนยัน</span>
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>หมายเหตุ:</strong> การแก้ไขการจองจะต้องรอการยืนยันจากผู้ดูแลระบบอีกครั้ง
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
