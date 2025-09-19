@extends('layouts.app')

@section('title', 'เข้าสู่ระบบ - ระบบร้านเช่าชุด')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <i class="fas fa-sign-in-alt fa-3x text-primary mb-3"></i>
                    <h3>เข้าสู่ระบบ</h3>
                    <p class="text-muted">เข้าสู่ระบบเพื่อจองชุด</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">อีเมล</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required autofocus>
                        </div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">รหัสผ่าน</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            จดจำการเข้าสู่ระบบ
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">
                        <i class="fas fa-sign-in-alt me-2"></i>เข้าสู่ระบบ
                    </button>
                </form>

                <div class="text-center">
                    <p class="mb-0">ยังไม่มีบัญชี? 
                        <a href="{{ route('register') }}" class="text-decoration-none">สมัครสมาชิก</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
