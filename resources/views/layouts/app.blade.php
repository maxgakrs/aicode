<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ระบบร้านเช่าชุด')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .navbar-brand {
            font-weight: bold;
            color: #e91e63 !important;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-2px);
        }
        .btn-primary {
            background-color: #e91e63;
            border-color: #e91e63;
        }
        .btn-primary:hover {
            background-color: #c2185b;
            border-color: #c2185b;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 2rem 0;
            margin-top: 3rem;
        }
        .costume-card img {
            height: 250px;
            object-fit: cover;
        }
        .status-badge {
            font-size: 0.8rem;
        }
        .hero-section {
            background: linear-gradient(135deg, #e91e63, #f06292);
        }
        .bg-gradient-primary {
            background: linear-gradient(135deg, #e91e63, #f06292);
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-tshirt me-2"></i>ระบบร้านเช่าชุด
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">หน้าแรก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('costumes.index') }}">ชุดทั้งหมด</a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>แดชบอร์ด
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('bookings.index') }}">
                                    <i class="fas fa-calendar-check me-2"></i>การจองของฉัน
                                </a></li>
                                @if(Auth::user()->isAdmin())
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('admin.costumes.index') }}">
                                    <i class="fas fa-cog me-2"></i>จัดการชุด
                                </a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>ออกจากระบบ
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">เข้าสู่ระบบ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">สมัครสมาชิก</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container my-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>ระบบร้านเช่าชุด</h5>
                    <p class="text-muted">บริการเช่าชุดคุณภาพดี ราคาเป็นมิตร</p>
                </div>
                <div class="col-md-6 text-end">
                    <p class="text-muted mb-0">&copy; {{ date('Y') }} ระบบร้านเช่าชุด. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JavaScript -->
    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }, 5000);
            });

            // Confirm delete actions
            const deleteForms = document.querySelectorAll('form[onsubmit*="confirm"]');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('คุณแน่ใจหรือไม่ที่จะดำเนินการนี้?')) {
                        e.preventDefault();
                    }
                });
            });

            // Date input validation
            const startDateInputs = document.querySelectorAll('#rental_start_date');
            const endDateInputs = document.querySelectorAll('#rental_end_date');
            
            startDateInputs.forEach((startInput, index) => {
                const endInput = endDateInputs[index];
                if (startInput && endInput) {
                    startInput.addEventListener('change', function() {
                        if (this.value) {
                            endInput.min = this.value;
                            if (endInput.value && endInput.value <= this.value) {
                                endInput.value = '';
                            }
                        }
                    });
                }
            });

            // Available date validation
            const fromDateInputs = document.querySelectorAll('#available_from');
            const toDateInputs = document.querySelectorAll('#available_to');
            
            fromDateInputs.forEach((fromInput, index) => {
                const toInput = toDateInputs[index];
                if (fromInput && toInput) {
                    fromInput.addEventListener('change', function() {
                        if (this.value) {
                            toInput.min = this.value;
                            if (toInput.value && toInput.value <= this.value) {
                                toInput.value = '';
                            }
                        }
                    });
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
