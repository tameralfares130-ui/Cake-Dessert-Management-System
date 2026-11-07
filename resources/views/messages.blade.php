@extends('layouts.app')
@section('title','Messages')
@section('content')<h1>Visitor Messages</h1><p class="text-muted">Available only to signed-in users. Newest first.</p>
@forelse($messages as $message)<article class="card mb-3"><div class="card-body"><div class="d-flex justify-content-between flex-wrap gap-2"><h2 class="h5">{{ $message->subject }}</h2><time class="small text-muted" datetime="{{ $message->created_at->toIso8601String() }}">{{ $message->created_at->format('Y-m-d H:i:s') }}</time></div><p class="small text-muted">From {{ $message->name }} ({{ $message->email }})</p><p class="mb-0" style="white-space: pre-wrap">{{ $message->message }}</p></div></article>@empty<p>No messages have been sent yet.</p>@endforelse
{{ $messages->links('pagination::bootstrap-5') }}
@endsection
