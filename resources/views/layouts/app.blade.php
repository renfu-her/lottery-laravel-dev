<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>抽奖系统 - @yield('title', '首页')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
        }

        .navbar {
            background-color: #1e1e1e !important;
        }

        .table {
            color: #ffffff;
        }

        .btn-info {
            color: #ffffff;
        }
    </style>
    @stack('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('prizes.index') }}">抽奖系统</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('prizes.index') ? 'active' : '' }}"
                            href="{{ route('prizes.index') }}">奖品列表</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('prizes.create') ? 'active' : '' }}"
                            href="{{ route('prizes.create') }}">添加奖品</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('lottery.winners') ? 'active' : '' }}"
                            href="{{ route('lottery.winners') }}">获奖记录</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="mt-5 py-3 bg-dark">
        <div class="container text-center">
            <span class="text-muted">&copy; {{ date('Y') }} 抽奖系统. 保留所有权利。</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
