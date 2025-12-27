<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GearPOS</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #F9FAFB 0%, #F3F4F6 50%, #F9FAFB 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .login-container {
            display: flex;
            align-items: center;
            gap: 100px;
            max-width: 1200px;
            width: 100%;
        }
        
        /* Left Side - Branding */
        .branding-section {
            flex: 1;
            max-width: 550px;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 44px;
        }
        
        .logo-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(180deg, #10B981 0%, #3B82F6 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 30px;
            font-weight: 400;
            line-height: 36px;
        }
        
        .logo-text {
            color: #1A1A1A;
            font-size: 36px;
            font-weight: 400;
            line-height: 40px;
        }
        
        .headline {
            color: #1A1A1A;
            font-size: 36px;
            font-weight: 400;
            line-height: 40px;
            margin-bottom: 20px;
        }
        
        .description {
            color: #6B7280;
            font-size: 20px;
            font-weight: 400;
            line-height: 28px;
            max-width: 550px;
            margin-bottom: 44px;
        }
        
        .stats-container {
            display: flex;
            gap: 16px;
        }
        
        .stat-card {
            background: white;
            box-shadow: 0px 1px 2px -1px rgba(0, 0, 0, 0.10);
            border-radius: 16px;
            padding: 16px;
            min-width: 180px;
        }
        
        .stat-value {
            color: #10B981;
            font-size: 30px;
            font-weight: 400;
            line-height: 36px;
        }
        
        .stat-label {
            color: #6B7280;
            font-size: 14px;
            font-weight: 400;
            line-height: 20px;
            margin-top: 8px;
        }
        
        /* Right Side - Login Form */
        .login-card {
            width: 100%;
            max-width: 500px;
            background: white;
            box-shadow: 0px 25px 50px -12px rgba(0, 0, 0, 0.25);
            border-radius: 16px;
            border: 1.5px solid rgba(0, 0, 0, 0.10);
            padding: 24px;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 24px;
        }
        
        .login-title {
            color: #1A1A1A;
            font-size: 30px;
            font-weight: 400;
            line-height: 36px;
            margin-bottom: 12px;
        }
        
        .login-subtitle {
            color: #6B7280;
            font-size: 16px;
            font-weight: 400;
            line-height: 24px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            color: #1A1A1A;
            font-size: 16px;
            font-weight: 400;
            line-height: 24px;
            margin-bottom: 8px;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6B7280;
            font-size: 18px;
        }
        
        .form-input {
            width: 100%;
            padding: 8px 12px 8px 40px;
            background: #F3F4F6;
            border: 1.5px solid transparent;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 400;
            color: #1A1A1A;
            outline: none;
            transition: border-color 0.2s;
        }
        
        .form-input::placeholder {
            color: #6B7280;
        }
        
        .form-input:focus {
            border-color: #10B981;
        }
        
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6B7280;
            cursor: pointer;
            background: none;
            border: none;
            font-size: 18px;
        }
        
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6B7280;
            font-size: 14px;
            font-weight: 400;
            line-height: 20px;
            cursor: pointer;
        }
        
        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #10B981;
        }
        
        .forgot-password {
            color: #10B981;
            font-size: 14px;
            font-weight: 400;
            line-height: 20px;
            text-decoration: none;
        }
        
        .forgot-password:hover {
            text-decoration: underline;
        }
        
        .btn-login {
            width: 100%;
            padding: 10px 20px;
            background: #10B981;
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 14px;
            font-weight: 500;
            line-height: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.2s;
        }
        
        .btn-login:hover {
            background: #059669;
        }
        
        .login-footer {
            text-align: center;
            margin-top: 24px;
        }
        
        .login-footer span {
            color: #6B7280;
            font-size: 14px;
            font-weight: 400;
            line-height: 20px;
        }
        
        .login-footer a {
            color: #10B981;
            font-size: 14px;
            font-weight: 400;
            line-height: 20px;
            text-decoration: none;
        }
        
        .login-footer a:hover {
            text-decoration: underline;
        }
        
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .alert-danger {
            background: #FEE2E2;
            color: #DC2626;
        }
        
        .alert-success {
            background: #D1FAE5;
            color: #059669;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .login-container {
                flex-direction: column;
                gap: 40px;
            }
            
            .branding-section {
                text-align: center;
                max-width: 100%;
            }
            
            .logo {
                justify-content: center;
            }
            
            .description {
                margin-left: auto;
                margin-right: auto;
            }
            
            .stats-container {
                justify-content: center;
            }
        }
        
        @media (max-width: 640px) {
            body {
                padding: 1rem;
            }
            
            .headline {
                font-size: 28px;
                line-height: 36px;
            }
            
            .description {
                font-size: 16px;
                line-height: 24px;
            }
            
            .stats-container {
                flex-direction: column;
                align-items: center;
            }
            
            .stat-card {
                width: 100%;
                max-width: 280px;
            }
            
            .login-card {
                padding: 20px;
            }
            
            .login-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Side - Branding -->
        <div class="branding-section">
            <div class="logo">
                <div class="logo-icon">GP</div>
                <div class="logo-text">GearPos</div>
            </div>
            
            <h1 class="headline">Kelola Toko Sparepart Motor dengan Lebih Mudah</h1>
            
            <p class="description">Sistem manajemen sparepart motor modern yang membantu Anda mengelola stok, penjualan, dan laporan inventaris secara real-time.</p>
            
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-value">10K+</div>
                    <div class="stat-label">Pengguna Aktif</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">99.9%</div>
                    <div class="stat-label">Uptime</div>
                </div>
            </div>
        </div>
        
        <!-- Right Side - Login Form -->
        <div class="login-card">
            <div class="login-header">
                <h2 class="login-title">Masuk ke Akun Anda</h2>
                <p class="login-subtitle">Masukkan kredensial Anda untuk mengakses dashboard</p>
            </div>
            
            @if($errors->any())
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle"></i> {{ $errors->first() }}
            </div>
            @endif
            
            @if(session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
            </div>
            @endif
            
            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <div class="input-wrapper">
                        <i class="bi bi-person input-icon"></i>
                        <input type="text" class="form-input" name="username" 
                               value="{{ old('username') }}" placeholder="Masukkan username" required autofocus>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-wrapper">
                        <i class="bi bi-lock input-icon"></i>
                        <input type="password" class="form-input" name="password" id="password"
                               placeholder="••••••••" required>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>
                
                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        Ingat saya
                    </label>
                    <a href="#" class="forgot-password">Lupa password?</a>
                </div>
                
                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Masuk
                </button>
            </form>
            
            <!-- <div class="login-footer">
                <span>Belum punya akun?</span>
                <a href="#">Daftar sekarang</a>
            </div> -->
        </div>
    </div>
    
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        }
    </script>
</body>
</html>
