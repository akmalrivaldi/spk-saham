<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SPK Saham Bank</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #6ea8fe);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            border: none;
            border-radius: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow login-card">
                    <div class="card-body p-4">
                        <h3 class="text-center fw-bold mb-3">Daftar Akun Baru</h3>
                        <p class="text-center text-muted mb-4">
                            Sistem Pendukung Keputusan Pemilihan Saham Terbaik
                        </p>

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('register.post') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Masukkan email" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Daftar</button>
                        </form>

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>
