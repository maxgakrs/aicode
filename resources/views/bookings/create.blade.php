@extends('layouts.app')

@section('title', 'จองชุด - ' . $costume->name)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-calendar-plus me-2"></i>จองชุด: {{ $costume->name }}</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('bookings.store') }}">
                    @csrf
                    <input type="hidden" name="costume_id" value="{{ $costume->id }}">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="rental_start_date" class="form-label">วันที่เริ่มเช่า</label>
                            <input type="date" class="form-control @error('rental_start_date') is-invalid @enderror" 
                                   id="rental_start_date" name="rental_start_date" 
                                   value="{{ old('rental_start_date') }}" 
                                   min="{{ date('Y-m-d') }}" required>
                            @error('rental_start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="rental_end_date" class="form-label">วันที่สิ้นสุดการเช่า</label>
                            <input type="date" class="form-control @error('rental_end_date') is-invalid @enderror" 
                                   id="rental_end_date" name="rental_end_date" 
                                   value="{{ old('rental_end_date') }}" required>
                            @error('rental_end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">หมายเหตุ (ไม่บังคับ)</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="3" 
                                  placeholder="หมายเหตุเพิ่มเติม...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('costumes.show', $costume) }}" class="btn btn-outline-secondary me-md-2">
                            <i class="fas fa-arrow-left me-2"></i>ย้อนกลับ
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-calendar-check me-2"></i>ยืนยันการจอง
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-info-circle me-2"></i>รายละเอียดชุด</h5>
            </div>
            <div class="card-body">
                @if($costume->image)
                <img src="{{ asset('storage/' . $costume->image) }}" class="img-fluid rounded mb-3" alt="{{ $costume->name }}">
                @else
                <div class="bg-light rounded mb-3 d-flex align-items-center justify-content-center" style="height: 200px;">
                    <i class="fas fa-image fa-3x text-muted"></i>
                </div>
                @endif
                
                <h5>{{ $costume->name }}</h5>
                <p class="text-muted">{{ $costume->description }}</p>
                
                <div class="mb-3">
                    @if($costume->category)
                    <span class="badge bg-info me-1">{{ $costume->category }}</span>
                    @endif
                    @if($costume->size)
                    <span class="badge bg-secondary me-1">ขนาด: {{ $costume->size }}</span>
                    @endif
                    @if($costume->color)
                    <span class="badge bg-light text-dark me-1">สี: {{ $costume->color }}</span>
                    @endif
                </div>
                
                <div class="mb-3">
                    <h4 class="text-primary">฿{{ number_format($costume->price_per_day) }} <small class="text-muted">/ วัน</small></h4>
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>หมายเหตุ:</strong> หลังจากจองแล้ว กรุณาอัพโหลดสลิปการโอนเงินเพื่อยืนยันการจอง
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

