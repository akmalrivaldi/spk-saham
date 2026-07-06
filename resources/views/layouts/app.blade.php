<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SPK Saham Bank' }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar-brand {
            font-weight: 700;
        }

        .page-title {
            font-weight: 700;
        }

        .card-stat {
            border: none;
            border-radius: 14px;
        }

        .footer {
            margin-top: 60px;
            padding: 20px 0;
            background: #fff;
            border-top: 1px solid #dee2e6;
        }

        .role-badge {
            font-size: 0.7rem;
            vertical-align: middle;
        }
    </style>
</head>
<body>

    @auth
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">SPK Saham Bank</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarApp" aria-controls="navbarApp" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarApp">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-semibold' : '' }}">
                            Dashboard
                        </a>
                    </li>

                    @if(auth()->user()->isAdmin())
                    <li class="nav-item">
                        <a href="{{ route('stocks.index') }}" class="nav-link {{ request()->routeIs('stocks.*') ? 'active fw-semibold' : '' }}">
                            Saham
                        </a>
                    </li>
                    @endif

                    <li class="nav-item">
                        <a href="{{ route('periods.index') }}" class="nav-link {{ request()->routeIs('periods.*') ? 'active fw-semibold' : '' }}">
                            Periode
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('criteria.index') }}" class="nav-link {{ request()->routeIs('criteria.*') ? 'active fw-semibold' : '' }}">
                            Kriteria
                        </a>
                    </li>

                    @if(auth()->user()->isAdmin())
                    <li class="nav-item">
                        <a href="{{ route('stock-values.index') }}" class="nav-link {{ request()->routeIs('stock-values.*') ? 'active fw-semibold' : '' }}">
                            Penilaian
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('calculations.index') }}" class="nav-link {{ request()->routeIs('calculations.*') ? 'active fw-semibold' : '' }}">
                            Perhitungan
                        </a>
                    </li>
                    @endif

                    <li class="nav-item">
                        <a href="{{ route('rankings.index') }}" class="nav-link {{ request()->routeIs('rankings.*') ? 'active fw-semibold' : '' }}">
                            Ranking
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('simulation.index') }}" class="nav-link {{ request()->routeIs('simulation.*') ? 'active fw-semibold' : '' }}">
                            Simulasi
                        </a>
                    </li>

                    @if(auth()->user()->isAdmin())
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active fw-semibold' : '' }}">
                            Manajemen User
                        </a>
                    </li>
                    @endif
                </ul>

                <div class="d-flex align-items-center text-white">
                    <span class="me-3">
                        Halo, {{ auth()->user()->name }}
                        @if(auth()->user()->isAdmin())
                            <span class="badge bg-warning text-dark role-badge">Admin</span>
                        @else
                            <span class="badge bg-light text-dark role-badge">User</span>
                        @endif
                    </span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-light btn-sm">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    @endauth

    <main class="py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="footer">
        <div class="container text-center">
            <small class="text-muted">
                &copy; {{ date('Y') }} SPK Pemilihan Saham Terbaik Metode Weighted Product
            </small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>