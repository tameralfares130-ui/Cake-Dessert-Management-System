@extends('layouts.app')
@section('title','Contact')
@section('content')<div class="row justify-content-center"><div class="col-lg-8"><h1>Contact us</h1><p class="text-muted">Leave us a message. Fields are validated on the server and saved to the database.</p><div class="card"><div class="card-body p-4"><form action="{{ route('contact.store') }}" method="POST">@csrf
<div class="mb-3"><label class="form-label" for="name">Name</label><input class="form-control" id="name" name="name" value="{{ old('name') }}" required maxlength="100"></div>
<div class="mb-3"><label class="form-label" for="email">Email</label><input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" required></div>
<div class="mb-3"><label class="form-label" for="subject">Subject</label><input class="form-control" id="subject" name="subject" value="{{ old('subject') }}" required maxlength="150"></div>
<div class="mb-3"><label class="form-label" for="message">Message (at least 10 characters)</label><textarea class="form-control" id="message" name="message" rows="5" required minlength="10" maxlength="3000">{{ old('message') }}</textarea></div><button class="btn btn-primary" type="submit">Send message</button></form></div></div></div></div>
<p class="small text-muted mt-3">
    Please fill in all required fields before submitting your message.
</p>
@endsection
