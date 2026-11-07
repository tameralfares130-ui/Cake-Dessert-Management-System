<!doctype html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title','Cake & Dessert') | Cake & Dessert Management</title>
<link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/minty/bootstrap.min.css" rel="stylesheet">
<link href="{{ asset('css/site.css') }}" rel="stylesheet">
</head><body class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm"><div class="container">
<a class="navbar-brand fw-bold" href="{{ route('home') }}">🍰 Sweet Crumbs</a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
<div class="collapse navbar-collapse" id="mainNav"><ul class="navbar-nav me-auto">
<li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Mainpage</a></li>
<li class="nav-item"><a class="nav-link" href="{{ route('database') }}">Database</a></li>
<li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
<li class="nav-item"><a class="nav-link" href="{{ route('graph') }}">Graph</a></li>
@auth<li class="nav-item"><a class="nav-link" href="{{ route('messages') }}">Messages</a></li>
@if(auth()->user()->isAdmin())<li class="nav-item"><a class="nav-link" href="{{ route('admin.confections.index') }}">CRUD Admin</a></li>@endif @endauth
</ul><ul class="navbar-nav align-items-lg-center">
@guest<li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li><li class="nav-item"><a class="btn btn-primary btn-sm" href="{{ route('register') }}">Register</a></li>@else
<li class="nav-item me-2 small text-muted">{{ auth()->user()->name }} ({{ auth()->user()->role }})</li>
<li class="nav-item"><form action="{{ route('logout') }}" method="POST">@csrf<button class="btn btn-outline-primary btn-sm" type="submit">Logout</button></form></li>@endguest
</ul></div></div></nav>
<main class="flex-grow-1"><div class="container py-4">
@if(session('success'))<div class="alert alert-success" role="alert">{{ session('success') }}</div>@endif
@if($errors->any())<div class="alert alert-danger"><strong>Please fix the following:</strong><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
@yield('content')
</div></main>
<footer class="bg-white border-top py-4 mt-4"><div class="container d-flex flex-wrap justify-content-between gap-2 small text-muted"><span>Sweet Crumbs · Laravel Confectionery Coursework</span><span>Creators: [Tamer Al Fares/Q542ZU] · [Shahriar Mir Munem/C2tb9p]</span></div></footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body></html>
