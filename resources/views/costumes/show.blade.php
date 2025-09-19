@extends('layouts.app')

@section('title', $costume->name . ' - ระบบร้านเช่าชุด')

@section('content')
<div class="row">
    <div class="col-md-6">
        @if($costume->image)
        <img src="{{ asset('storage/' . $costume->image) }}" class="img-fluid rounded shadow" alt="{{ $costume->name }}">
        @else
        <div class="bg-light rounded shadow d-flex align-items-center justify-content-center" style="height: 400px;">
            <i class="fas fa-image fa-5x text-muted"></i>
        </div>
        @endif
    </div>
    
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <h1 class="card-title">{{ $costume->name }}</h1>
                
                <div class="mb-3">
                    @if($costume->category)
                    <span class="badge bg-info me-2">{{ $costume->category }}</span>
                    @endif
                    @if($costume->size)
                    <span class="badge bg-secondary me-2">ขนาด: {{ $costume->size }}</span>
                    @endif
                    @if($costume->color)
                    <span class="badge bg-light text-dark me-2">สี: {{ $costume->color }}</span>
                    @endif
                    <span class="badge bg-{{ $costume->status == 'available' ? 'success' : ($costume->status == 'rented' ? 'warning' : 'danger') }}">
                        {{ $costume->status == 'available' ? 'พร้อมให้เช่า' : ($costume->status == 'rented' ? 'ถูกเช่าแล้ว' : 'ซ่อมบำรุง') }}
                    </span>
                </div>

                <div class="mb-4">
                    <h3 class="text-primary">฿{{ number_format($costume->price_per_day) }} <small class="text-muted">/ วัน</small></h3>
                </div>

                @if($costume->description)
                <div class="mb-4">
                    <h5>รายละเอียด</h5>
                    <p class="text-muted">{{ $costume->description }}</p>
                </div>
                @endif

                @if($costume->available_from || $costume->available_to)
                <div class="mb-4">
                    <h5>ช่วงเวลาที่ให้เช่า</h5>
                    <p class="text-muted">
                        @if($costume->available_from)
                        ตั้งแต่: {{ $costume->available_from->format('d/m/Y') }}
                        @endif
                        @if($costume->available_to)
                        ถึง: {{ $costume->available_to->format('d/m/Y') }}
                        @endif
                    </p>
                </div>
                @endif

                <div class="d-grid gap-2">
                    @if($costume->isAvailable() && auth()->check())
                    <a href="{{ route('bookings.create', $costume) }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-calendar-plus me-2"></i>จองชุดนี้
                    </a>
                    @elseif(!auth()->check())
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-sign-in-alt me-2"></i>เข้าสู่ระบบเพื่อจอง
                    </a>
                    @else
                    <button class="btn btn-secondary btn-lg" disabled>
                        <i class="fas fa-ban me-2"></i>ไม่พร้อมให้เช่า
                    </button>
                    @endif
                    
                    <a href="{{ route('costumes.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>กลับไปดูชุดทั้งหมด
                    </a>
                </div>

                @auth
                    @if(Auth::user()->isAdmin())
                    <hr>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.costumes.edit', $costume) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i>แก้ไขชุด
                        </a>
                        <form method="POST" action="{{ route('admin.costumes.destroy', $costume) }}" 
                              onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบชุดนี้?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-trash me-2"></i>ลบชุด
                            </button>
                        </form>
                    </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
