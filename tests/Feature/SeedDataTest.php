<?php

namespace Tests\Feature;

use App\Models\Confection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeedDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_original_dataset_can_be_seeded_twice_without_duplicates(): void
    {
        $this->seed();
        $this->seed();
        $this->assertDatabaseCount('confections', 139);
        $this->assertDatabaseCount('contents', 45);
        $this->assertDatabaseCount('prices', 208);
        $this->assertSame(0, \App\Models\Price::whereDoesntHave('confection')->count());
        $this->assertSame(0, \App\Models\Content::whereDoesntHave('confection')->count());
        $this->assertTrue(Confection::where('prizewinning', -1)->exists());
        $this->get('/database')->assertOk()->assertSee('139');
        $this->get('/graph')->assertOk()->assertSee('139 confectionery products')->assertSee('208 price entries');
    }
}
