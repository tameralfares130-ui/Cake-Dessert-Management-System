@extends('layouts.app')
@section('title', 'Graph')
@section('content')
<h1>Confectionery Statistics</h1>
<p class="text-muted">
    The charts summarize {{ $types->sum('total') }} confectionery products
    and {{ $units->sum('total') }} price entries.
</p>
<p class="text-muted">Charts use database records via Eloquent and Chart.js. The tables below provide the same values in text.</p>
<div class="row g-4">
    <div class="col-lg-7">
        <section class="card p-3 h-100" aria-labelledby="types-heading">
            <h2 class="h5" id="types-heading">Confections by type</h2>
            @if($types->isNotEmpty())
                <canvas id="typeChart" role="img" aria-label="Bar chart showing number of confections per type" aria-describedby="type-data"></canvas>
            @endif
            <div class="table-responsive mt-3" id="type-data">
                <table class="table table-striped mb-0">
                    <caption>Product counts by confection type</caption>
                    <thead><tr><th scope="col">Type</th><th scope="col">Products</th></tr></thead>
                    <tbody>
                        @forelse($types as $type)
                            <tr><th scope="row">{{ $type->type }}</th><td>{{ $type->total }}</td></tr>
                        @empty
                            <tr><td colspan="2">No confection data available.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
    <div class="col-lg-5">
        <section class="card p-3 h-100" aria-labelledby="units-heading">
            <h2 class="h5" id="units-heading">Price entries by unit</h2>
            @if($units->isNotEmpty())
                <canvas id="unitChart" role="img" aria-label="Doughnut chart of price entries per unit" aria-describedby="unit-data"></canvas>
            @endif
            <div class="table-responsive mt-3" id="unit-data">
                <table class="table table-striped mb-0">
                    <caption>Price-entry counts by unit, not price comparisons</caption>
                    <thead><tr><th scope="col">Unit</th><th scope="col">Entries</th></tr></thead>
                    <tbody>
                        @forelse($units as $unit)
                            <tr><th scope="row">{{ $unit->unit ?: 'Unspecified' }}</th><td>{{ $unit->total }}</td></tr>
                        @empty
                            <tr><td colspan="2">No price data available.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js"></script>
<script>
const typeLabels = @json($types->pluck('type'));
const typeTotals = @json($types->pluck('total'));
const unitLabels = @json($units->map(fn ($unit) => $unit->unit ?: 'Unspecified')->values());
const unitTotals = @json($units->pluck('total'));
if (typeof Chart !== 'undefined') {
    const typeCanvas = document.getElementById('typeChart');
    const unitCanvas = document.getElementById('unitChart');
    if (typeCanvas) new Chart(typeCanvas, {type:'bar', data:{labels:typeLabels, datasets:[{label:'Products', data:typeTotals, backgroundColor:'#67c3b1'}]}, options:{responsive:true, scales:{y:{beginAtZero:true, ticks:{precision:0}}}}});
    if (unitCanvas) new Chart(unitCanvas, {type:'doughnut', data:{labels:unitLabels, datasets:[{data:unitTotals, backgroundColor:['#67c3b1','#f39cad','#ffce80','#9eaddc','#a2d5eb','#dcb9ea','#8fcfa0']}]}, options:{responsive:true}});
}
</script>
@endpush
