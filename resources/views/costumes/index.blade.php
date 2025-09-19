@extends('layouts.app')

@section('title', 'จัดการชุด - ระบบร้านเช่าชุด')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-tshirt me-2"></i>จัดการชุด</h2>
            <a href="{{ route('admin.costumes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>เพิ่มชุดใหม่
            </a>
        </div>

        <!-- Filter Section -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.costumes.index') }}">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">ค้นหาชุด</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="ชื่อชุด...">
                        </div>
                        <div class="col-md-3">
                            <label for="category" class="form-label">หมวดหมู่</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">ทั้งหมด</option>
                                @foreach(['ชุดไทย', 'ชุดสากล', 'ชุดงาน', 'ชุดแฟนซี'] as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label">สถานะ</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">ทั้งหมด</option>
                                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>พร้อมให้เช่า</option>
                                <option value="rented" {{ request('status') == 'rented' ? 'selected' : '' }}>ถูกเช่าแล้ว</option>
                                <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>ซ่อมบำรุง</option>
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

        <!-- Costumes Grid -->
        @if($costumes->count() > 0)
        <div class="row">
            @foreach($costumes as $costume)
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
                        
                        <div class="mb-2">
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

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="h5 text-primary mb-0">฿{{ number_format($costume->price_per_day) }}/วัน</span>
                            <span class="badge bg-{{ $costume->status == 'available' ? 'success' : ($costume->status == 'rented' ? 'warning' : 'danger') }} status-badge">
                                {{ $costume->status == 'available' ? 'พร้อมให้เช่า' : ($costume->status == 'rented' ? 'ถูกเช่าแล้ว' : 'ซ่อมบำรุง') }}
                            </span>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ route('costumes.show', $costume) }}" class="btn btn-outline-primary">
                                <i class="fas fa-eye me-2"></i>ดูรายละเอียด
                            </a>
                            <a href="{{ route('admin.costumes.edit', $costume) }}" class="btn btn-outline-warning">
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
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $costumes->appends(request()->query())->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-search fa-5x text-muted mb-3"></i>
            <h4 class="text-muted">ไม่พบชุดที่ค้นหา</h4>
            <p class="text-muted">ลองเปลี่ยนเงื่อนไขการค้นหาหรือเพิ่มชุดใหม่</p>
            <a href="{{ route('admin.costumes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>เพิ่มชุดใหม่
            </a>
        </div>
        @endif
    </div>
</div>
@endsection