@extends('layouts.app')
@section('title','Edit Confection')
@section('content')<h1>Edit confection #{{ $confection->id }}</h1><div class="card"><div class="card-body"><form method="POST" action="{{ route('admin.confections.update',$confection) }}">@method('PUT') @include('admin._form')</form></div></div>
@endsection
