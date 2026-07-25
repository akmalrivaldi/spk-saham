<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SPK Saham Bank' }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Modern CSS -->
    <link href="{{ asset('css/modern.css') }}" rel="stylesheet">
</head>
<body>

    @auth
    <!-- Sidebar -->
    <aside id="sidebar">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <i class="ph-fill ph-chart-line-up"></i>
            <span>SPK Saham</span>
        </a>

        <div class="sidebar-nav">
            <div class="sidebar-heading">Menu Utama</div>
            
            <div class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="ph ph-squares-four"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            @if(auth()->user()->isAdmin())
            <div class="nav-item">
                <a href="{{ route('stocks.index') }}" class="nav-link {{ request()->routeIs('stocks.*') ? 'active' : '' }}">
                    <i class="ph ph-buildings"></i>
                    <span>Data Saham</span>
                </a>
            </div>
            @endif

            <div class="nav-item">
                <a href="{{ route('periods.index') }}" class="nav-link {{ request()->routeIs('periods.*') ? 'active' : '' }}">
                    <i class="ph ph-calendar-blank"></i>
                    <span>Periode</span>
                </a>
            </div>
            
            <div class="nav-item">
                <a href="{{ route('criteria.index') }}" class="nav-link {{ request()->routeIs('criteria.*') ? 'active' : '' }}">
                    <i class="ph ph-list-numbers"></i>
                    <span>Kriteria</span>
                </a>
            </div>

            <div class="sidebar-heading">Penilaian (WP)</div>

            @if(auth()->user()->isAdmin())
            <div class="nav-item">
                <a href="{{ route('stock-values.index') }}" class="nav-link {{ request()->routeIs('stock-values.*') ? 'active' : '' }}">
                    <i class="ph ph-exam"></i>
                    <span>Nilai Alternatif</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('calculations.index') }}" class="nav-link {{ request()->routeIs('calculations.*') ? 'active' : '' }}">
                    <i class="ph ph-calculator"></i>
                    <span>Perhitungan</span>
                </a>
            </div>
            @endif

            <div class="nav-item">
                <a href="{{ route('rankings.index') }}" class="nav-link {{ request()->routeIs('rankings.*') ? 'active' : '' }}">
                    <i class="ph ph-trophy"></i>
                    <span>Hasil Ranking</span>
                </a>
            </div>
            
            <div class="nav-item">
                <a href="{{ route('simulation.index') }}" class="nav-link {{ request()->routeIs('simulation.*') ? 'active' : '' }}">
                    <i class="ph ph-flask"></i>
                    <span>Simulasi Bobot</span>
                </a>
            </div>

            @if(auth()->user()->isAdmin())
            <div class="sidebar-heading">Pengaturan</div>
            <div class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="ph ph-users"></i>
                    <span>Manajemen User</span>
                </a>
            </div>
            @endif
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div id="content-wrapper">
        <!-- Topbar -->
        <header class="topbar">
            <button class="topbar-toggler" id="sidebarToggle">
                <i class="ph ph-list"></i>
            </button>

            <div class="topbar-right">
                <div class="user-profile">
                    <div class="user-info text-end me-2 d-none d-md-flex">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <span class="user-role">{{ auth()->user()->isAdmin() ? 'Administrator' : 'Pengguna' }}</span>
                    </div>
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
                
                <form action="{{ route('logout') }}" method="POST" class="ms-2 border-start ps-3 border-2">
                    @csrf
                    <button type="submit" class="btn btn-light btn-sm d-flex align-items-center gap-2">
                        <i class="ph ph-sign-out"></i> <span class="d-none d-md-inline">Logout</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: '{!! session('success') !!}',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    });
                </script>
            @endif

            @if(session('error'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: '{!! session('error') !!}',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    });
                </script>
            @endif

            @if($errors->any())
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal!',
                            text: 'Silakan periksa kembali inputan Anda.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true
                        });
                    });
                </script>
            @endif

            @yield('content')
        </main>

        <footer class="footer">
            &copy; {{ date('Y') }} SPK Pemilihan Saham Terbaik Metode Weighted Product
        </footer>
    </div>
    
    <!-- Backdrop for mobile sidebar -->
    <div id="sidebar-backdrop" class="d-none" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.5); z-index: 998;"></div>
    @else
        <!-- For non-auth pages like login/register -->
        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    
    <script>
        // Sidebar Toggle Logic for Mobile
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebarToggle');
            const backdrop = document.getElementById('sidebar-backdrop');
            
            if(toggleBtn && sidebar) {
                function toggleSidebar() {
                    sidebar.classList.toggle('show');
                    if(sidebar.classList.contains('show')) {
                        backdrop.classList.remove('d-none');
                    } else {
                        backdrop.classList.add('d-none');
                    }
                }
                
                toggleBtn.addEventListener('click', toggleSidebar);
                backdrop.addEventListener('click', toggleSidebar);
            }

            // SweetAlert Delete Confirmation Global
            const deleteForms = document.querySelectorAll('.form-delete');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        background: '#ffffff',
                        borderRadius: '20px'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>