@extends('layouts.app')
@section('title','Login')
@section('content')<div class="row justify-content-center"><div class="col-md-6"><h1>Login</h1><div class="card"><div class="card-body p-4"><form method="POST" action="{{ route('login.submit') }}">@csrf
<div class="mb-3"><label for="email" class="form-label">Email</label><input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus></div><div class="mb-3"><label for="password" class="form-label">Password</label><input id="password" class="form-control" type="password" name="password" required></div><button class="btn btn-primary" type="submit">Login</button></form></div></div></div></div>
@endsection
