<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SPK Saham Bank</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <!-- Modern CSS -->
    <link href="{{ asset('css/modern.css') }}" rel="stylesheet">

    <style>
        body {
            background-color: var(--bg-light);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding: 2rem 0; /* Add padding for smaller screens if it overflows */
        }

        /* Dribbble-style decorative background blobs */
        .blob-1 {
            position: absolute;
            top: -10%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.4), rgba(79, 70, 229, 0.1));
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
        }
        
        .blob-2 {
            position: absolute;
            bottom: -10%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.3), rgba(16, 185, 129, 0.1));
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
        }

        .login-card {
            border: none;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        
        .form-control {
            border-radius: 12px;
            padding: 14px 20px;
            border: 1px solid var(--border-color);
            background-color: #F9FAFB;
            transition: all 0.2s;
            font-size: 0.95rem;
        }

        .form-control:focus {
            background-color: #FFF;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .btn-login {
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            background-color: var(--primary-color);
            border: none;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
        }

        .brand-icon {
            width: 64px;
            height: 64px;
            background-color: rgba(79, 70, 229, 0.1);
            color: var(--primary-color);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 20px;
        }
    </style>
</head>
<body>
    <div class="blob-1"></div>
    <div class="blob-2"></div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card login-card">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="brand-icon">
                                <i class="ph-fill ph-user-plus"></i>
                            </div>
                            <h3 class="fw-bold mb-1" style="color: var(--text-dark);">Daftar Akun Baru</h3>
                            <p class="text-muted small">Mulai analisa saham terbaik Anda</p>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success border-0 shadow-sm rounded-3 py-2 d-flex align-items-center gap-2">
                                <i class="ph-fill ph-check-circle"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger border-0 shadow-sm rounded-3 py-2 d-flex align-items-center gap-2">
                                <i class="ph-fill ph-warning-circle"></i>
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('register.post') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="John Doe" required>
                                @error('name')
                                    <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="user@example.com" required>
                                @error('email')
                                    <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
                                @error('password')
                                    <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 btn-login d-flex justify-content-center align-items-center gap-2">
                                Daftar Sekarang <i class="ph-bold ph-arrow-right"></i>
                            </button>
                        </form>

                        <div class="mt-4 text-center">
                            <span class="text-muted small">
                                Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: var(--primary-color);">Login di sini</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>
