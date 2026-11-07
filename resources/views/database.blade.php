
@extends('layouts.app')

@section('title', 'Database')

@section('content')
<h1>Confectionery Database</h1>

<p class="text-muted">
    Information from three related tables: confections, prices and contents.
    Prices are in HUF.
</p>

<form method="GET" action="{{ route('database') }}" class="row g-2 mb-4">
    <div class="col-md-5">
        <input
            class="form-control"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search cakes by name"
            aria-label="Search by name"
        >
    </div>

    <div class="col-md-4">
        <select
            class="form-select"
            name="type"
            aria-label="Filter confections by type"
        >
            <option value="">All types</option>
            @foreach($types as $type)
                <option value="{{ $type }}" @selected(request('type') === $type)>
                    {{ $type }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3 d-flex gap-2">
        <button class="btn btn-primary" type="submit">Filter</button>
        <a class="btn btn-outline-secondary" href="{{ route('database') }}">Reset</a>
    </div>
</form>

<div class="table-responsive rounded-3 shadow-sm bg-white">
    <table class="table table-striped table-hover align-middle mb-0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Confection</th>
                <th>Type</th>
                <th>Competition flag</th>
                <th>Prices (per unit)</th>
                <th>Free-from codes</th>
            </tr>
        </thead>

        <tbody>
            @forelse($confections as $cake)
                <tr>
                    <td>{{ $cake->id }}</td>
                    <td class="fw-semibold">{{ $cake->cname }}</td>
                    <td>{{ $cake->type }}</td>
                    <td>{{ $cake->prizewinning }}</td>

                    <td>
                        @forelse($cake->prices as $price)
                            <div>
                                {{ number_format($price->price) }} Ft /
                                {{ $price->unit ?: 'unspecified' }}
                            </div>
                        @empty
                            <span class="text-muted">—</span>
                        @endforelse
                    </td>

                    <td>
                        @forelse($cake->contents as $content)
                            <span class="badge text-bg-info me-1">
                                {{ $content->free }}
                            </span>
                        @empty
                            <span class="text-muted">—</span>
                        @endforelse
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No matching products.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $confections->links('pagination::bootstrap-5') }}
</div>

<p class="small text-muted">
    Dataset code values are preserved as supplied.
    The prizewinning field includes -1/0; the original description calls it
    Boolean but does not define -1.
    Dietary code G means gluten-free; other codes are shown as supplied.
</p>
@endsection
