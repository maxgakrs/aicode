@extends('layouts.app')

@section('title', 'หน้าแรก - ระบบร้านเช่าชุด')

@section('content')
<!-- Hero Section -->
<div class="hero-section bg-gradient-primary text-white py-5 mb-5 rounded">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">
            <i class="fas fa-tshirt me-3"></i>ระบบร้านเช่าชุด
        </h1>
        <p class="lead mb-4">บริการเช่าชุดคุณภาพดี ราคาเป็นมิตร พร้อมส่งมอบความสวยงามให้กับคุณ</p>
        <a href="{{ route('costumes.index') }}" class="btn btn-light btn-lg">
            <i class="fas fa-search me-2"></i>ดูชุดทั้งหมด
        </a>
    </div>
</div>

<!-- Categories Section -->
@if($categories->count() > 0)
<div class="row mb-5">
    <div class="col-12">
        <h3 class="text-center mb-4">หมวดหมู่ชุด</h3>
        <div class="row">
            @foreach($categories as $category)
            <div class="col-md-3 mb-3">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-tag fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">{{ $category }}</h5>
                        <a href="{{ route('costumes.index', ['category' => $category]) }}" class="btn btn-outline-primary">
                            ดูชุดในหมวดนี้
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Featured Costumes Section -->
<div class="row mb-5">
    <div class="col-12">
        <h3 class="text-center mb-4">ชุดแนะนำ</h3>
        @if($featuredCostumes->count() > 0)
        <div class="row">
            @foreach($featuredCostumes as $costume)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card costume-card h-100">
                    @if($costume->image)
                    <img src="{{ asset('storage/' . $costume->image) }}" class="card-img-top" alt="{{ $costume->name }}">
                    @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                        <i class="fas fa-image fa-3x text-muted"></i>
                    </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $costume->name }}</h5>
                        <p class="card-text text-muted flex-grow-1">
                            {{ Str::limit($costume->description, 100) }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 text-primary mb-0">฿{{ number_format($costume->price_per_day) }}/วัน</span>
                            <span class="badge bg-success status-badge">{{ $costume->status }}</span>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('costumes.show', $costume) }}" class="btn btn-primary w-100">
                                <i class="fas fa-eye me-2"></i>ดูรายละเอียด
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('costumes.index') }}" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-th-large me-2"></i>ดูชุดทั้งหมด
            </a>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-tshirt fa-5x text-muted mb-3"></i>
            <h4 class="text-muted">ยังไม่มีชุดในระบบ</h4>
            <p class="text-muted">กรุณารอการเพิ่มชุดจากผู้ดูแลระบบ</p>
        </div>
        @endif
    </div>
</div>

<!-- Features Section -->
<div class="row mb-5">
    <div class="col-12">
        <h3 class="text-center mb-4">ทำไมต้องเลือกเรา</h3>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-shield-alt fa-3x text-success mb-3"></i>
                        <h5 class="card-title">ปลอดภัย</h5>
                        <p class="card-text">ระบบจองออนไลน์ที่ปลอดภัย ข้อมูลส่วนตัวได้รับการปกป้อง</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-clock fa-3x text-info mb-3"></i>
                        <h5 class="card-title">สะดวก</h5>
                        <p class="card-text">จองชุดได้ตลอด 24 ชั่วโมง ไม่ต้องเดินทางมาเอง</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-star fa-3x text-warning mb-3"></i>
                        <h5 class="card-title">คุณภาพ</h5>
                        <p class="card-text">ชุดคุณภาพดี ราคาเป็นมิตร พร้อมส่งมอบความสวยงาม</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

