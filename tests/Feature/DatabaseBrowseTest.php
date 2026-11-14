<?php

namespace Tests\Feature;

use App\Models\Confection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseBrowseTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_and_type_filters_are_combined_and_show_related_data(): void
    {
        $cake = Confection::create(['cname' => 'Lemon celebration', 'type' => 'cake', 'prizewinning' => 0]);
        $cake->prices()->create(['price' => 4500, 'unit' => '8 slices']);
        $cake->contents()->create(['free' => 'G']);
        Confection::create(['cname' => 'Lemon pastry', 'type' => 'pastry', 'prizewinning' => 0]);
        Confection::create(['cname' => 'Chocolate cake', 'type' => 'cake', 'prizewinning' => 0]);

        $this->get('/database?search=Lemon&type=cake')->assertOk()
            ->assertSee('Lemon celebration')->assertSee('4,500')->assertSee('8 slices')
            ->assertDontSee('Lemon pastry')->assertDontSee('Chocolate cake')
            ->assertViewHas('confections', fn ($rows) => $rows->total() === 1
                && $rows->first()->contents->first()->free === 'G');
    }

    public function test_filters_survive_pagination(): void
    {
        for ($i = 1; $i <= 13; $i++) {
            Confection::create(['cname' => sprintf('Lemon %02d', $i), 'type' => 'cake', 'prizewinning' => 0]);
        }
        $this->get('/database?search=Lemon&type=cake')->assertOk()
            ->assertViewHas('confections', fn ($rows) => $rows->total() === 13
                && $rows->count() === 12
                && str_contains($rows->nextPageUrl(), 'search=Lemon')
                && str_contains($rows->nextPageUrl(), 'type=cake'));
        $this->get('/database?search=Lemon&type=cake&page=2')->assertOk()
            ->assertSee('Lemon 13')->assertDontSee('Lemon 01');
    }

    public function test_unknown_filter_displays_empty_result(): void
    {
        $this->get('/database?type=unknown')->assertOk()->assertSee('No matching products.');
    }

    public function test_malformed_or_oversized_filters_are_rejected(): void
    {
        foreach ([['search' => ['cake']], ['type' => ['cake']], ['search' => str_repeat('x', 256)],
            ['type' => str_repeat('x', 101)], ['page' => 0], ['page' => ['2']]] as $query) {
            $this->getJson('/database?'.http_build_query($query))->assertUnprocessable()
                ->assertJsonValidationErrors(array_keys($query));
        }
    }
}
