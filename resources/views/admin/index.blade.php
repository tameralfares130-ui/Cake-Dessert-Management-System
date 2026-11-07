@extends('layouts.app')
@section('title','Admin CRUD')
@section('content')<div class="d-flex justify-content-between align-items-center mb-3"><h1>Admin · Confection CRUD</h1><a href="{{ route('admin.confections.create') }}" class="btn btn-primary">+ Add confection</a></div>
<div class="table-responsive bg-white rounded-3 shadow-sm"><table class="table table-hover align-middle mb-0"><thead><tr><th>ID</th><th>Name</th><th>Type</th><th>Prize flag</th><th>Prices</th><th>Contents</th><th>Actions</th></tr></thead><tbody>
@foreach($confections as $cake)<tr><td>{{ $cake->id }}</td><td>{{ $cake->cname }}</td><td>{{ $cake->type }}</td><td>{{ $cake->prizewinning }}</td><td>{{ $cake->prices_count }}</td><td>{{ $cake->contents_count }}</td><td class="text-nowrap"><a href="{{ route('admin.confections.edit',$cake) }}" class="btn btn-sm btn-outline-primary">Edit</a>
<form method="POST" class="d-inline" action="{{ route('admin.confections.destroy',$cake) }}" onsubmit="return confirm('Delete this confection and all associated price/content entries?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button></form></td></tr>@endforeach
</tbody></table></div><div class="mt-3">{{ $confections->links('pagination::bootstrap-5') }}</div><p class="text-muted small">Deleting a confection also deletes associated prices and contents (foreign key cascade).</p>
@endsection
