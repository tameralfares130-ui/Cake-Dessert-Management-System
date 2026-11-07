@extends('layouts.app')
@section('title','Add Confection')
@section('content')<h1>Add confection</h1><div class="card"><div class="card-body"><form method="POST" action="{{ route('admin.confections.store') }}">@include('admin._form')</form></div></div>
@endsection
