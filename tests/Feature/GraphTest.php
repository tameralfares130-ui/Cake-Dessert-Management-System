<?php

namespace Tests\Feature;

use App\Models\Confection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GraphTest extends TestCase
{
    use RefreshDatabase;

    public function test_graph_shows_aggregated_data_in_accessible_tables(): void
    {
        $cake = Confection::create(['cname' => 'Cake one', 'type' => 'cake', 'prizewinning' => 0]);
        Confection::create(['cname' => 'Cake two', 'type' => 'cake', 'prizewinning' => 0]);
        $cake->prices()->create(['price' => 500, 'unit' => 'pce']);
        $cake->prices()->create(['price' => 900, 'unit' => '']);
        $this->get('/graph')->assertOk()
            ->assertSee('2 confectionery products')->assertSee('2 price entries')
            ->assertSee('Product counts by confection type')->assertSee('Unspecified')
            ->assertViewHas('types', fn ($types) => $types->count() === 1 && (int) $types->first()->total === 2)
            ->assertViewHas('units', fn ($units) => $units->count() === 2 && (int) $units->sum('total') === 2);
    }

    public function test_empty_database_has_explicit_graph_messages(): void
    {
        $this->get('/graph')->assertOk()->assertSee('No confection data available.')
            ->assertSee('No price data available.')->assertDontSee('<canvas', false);
    }
}
