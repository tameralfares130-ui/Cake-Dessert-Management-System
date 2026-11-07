@extends('layouts.app')
@section('title','Graph')
@section('content')<h1>Confectionery Statistics</h1><p class="text-muted">
    The charts summarize
    {{ $types->sum('total') }} confectionery products
    and {{ $units->sum('total') }} price entries.
</p><p class="text-muted">Charts are generated from live MySQL records via Eloquent and Chart.js.</p>
<div class="row g-4"><div class="col-lg-7"><div class="card p-3 h-100"><h2 class="h5">Confections by type</h2><canvas id="typeChart" role="img" aria-label="Bar chart showing number of confections per type"></canvas></div></div><div class="col-lg-5"><div class="card p-3 h-100"><h2 class="h5">Price entries by unit</h2><canvas id="unitChart" role="img" aria-label="Doughnut chart of price entries per unit"></canvas></div></div></div>
@endsection
@push('scripts')<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js"></script><script>
const typeLabels = @json($types->pluck('type'));
const typeTotals = @json($types->pluck('total'));
const unitLabels = @json($units->pluck('unit'));
const unitTotals = @json($units->pluck('total'));
new Chart(document.getElementById('typeChart'),{type:'bar',data:{labels:typeLabels,datasets:[{label:'Products',data:typeTotals,backgroundColor:'#67c3b1'}]},options:{responsive:true,scales:{y:{beginAtZero:true,ticks:{precision:0}}}}});
new Chart(document.getElementById('unitChart'),{type:'doughnut',data:{labels:unitLabels,datasets:[{data:unitTotals,backgroundColor:['#67c3b1','#f39cad','#ffce80','#9eaddc','#a2d5eb','#dcb9ea','#8fcfa0']}]},options:{responsive:true}});
</script>@endpush
