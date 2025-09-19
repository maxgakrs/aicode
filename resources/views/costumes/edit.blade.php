@extends('layouts.app')

@section('title', 'แก้ไขชุด - ' . $costume->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-edit me-2"></i>แก้ไขชุด: {{ $costume->name }}</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.costumes.update', $costume) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="name" class="form-label">ชื่อชุด</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $costume->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="price_per_day" class="form-label">ราคาต่อวัน (บาท)</label>
                            <input type="number" class="form-control @error('price_per_day') is-invalid @enderror" 
                                   id="price_per_day" name="price_per_day" value="{{ old('price_per_day', $costume->price_per_day) }}" 
                                   min="0" step="0.01" required>
                            @error('price_per_day')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">รายละเอียด</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description', $costume->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="category" class="form-label">หมวดหมู่</label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category">
                                <option value="">เลือกหมวดหมู่</option>
                                <option value="ชุดไทย" {{ old('category', $costume->category) == 'ชุดไทย' ? 'selected' : '' }}>ชุดไทย</option>
                                <option value="ชุดสากล" {{ old('category', $costume->category) == 'ชุดสากล' ? 'selected' : '' }}>ชุดสากล</option>
                                <option value="ชุดงาน" {{ old('category', $costume->category) == 'ชุดงาน' ? 'selected' : '' }}>ชุดงาน</option>
                                <option value="ชุดแฟนซี" {{ old('category', $costume->category) == 'ชุดแฟนซี' ? 'selected' : '' }}>ชุดแฟนซี</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="size" class="form-label">ขนาด</label>
                            <input type="text" class="form-control @error('size') is-invalid @enderror" 
                                   id="size" name="size" value="{{ old('size', $costume->size) }}" placeholder="เช่น S, M, L, XL">
                            @error('size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="color" class="form-label">สี</label>
                            <input type="text" class="form-control @error('color') is-invalid @enderror" 
                                   id="color" name="color" value="{{ old('color', $costume->color) }}" placeholder="เช่น แดง, น้ำเงิน">
                            @error('color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <label for="status" class="form-label">สถานะ</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="available" {{ old('status', $costume->status) == 'available' ? 'selected' : '' }}>พร้อมให้เช่า</option>
                                <option value="rented" {{ old('status', $costume->status) == 'rented' ? 'selected' : '' }}>ถูกเช่าแล้ว</option>
                                <option value="maintenance" {{ old('status', $costume->status) == 'maintenance' ? 'selected' : '' }}>ซ่อมบำรุง</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="available_from" class="form-label">วันที่เริ่มให้เช่า</label>
                            <input type="date" class="form-control @error('available_from') is-invalid @enderror" 
                                   id="available_from" name="available_from" value="{{ old('available_from', $costume->available_from?->format('Y-m-d')) }}">
                            @error('available_from')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="available_to" class="form-label">วันที่สิ้นสุดการให้เช่า</label>
                            <input type="date" class="form-control @error('available_to') is-invalid @enderror" 
                                   id="available_to" name="available_to" value="{{ old('available_to', $costume->available_to?->format('Y-m-d')) }}">
                            @error('available_to')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">รูปภาพชุด</label>
                        @if($costume->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $costume->image) }}" class="img-thumbnail" style="max-width: 200px;" alt="Current Image">
                            <p class="text-muted small">รูปภาพปัจจุบัน</p>
                        </div>
                        @endif
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        <div class="form-text">รองรับไฟล์: JPEG, PNG, JPG, GIF ขนาดไม่เกิน 2MB (เว้นว่างไว้หากไม่ต้องการเปลี่ยนรูป)</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('admin.costumes.index') }}" class="btn btn-outline-secondary me-md-2">
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
</div>
@endsection

