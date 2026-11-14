<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_messages_are_newest_first_with_timestamps_and_escaped_text(): void
    {
        $older = ContactMessage::create(['name' => 'Older sender', 'email' => 'older@example.com', 'subject' => 'Older message', 'message' => 'Older message body']);
        $older->created_at = '2026-01-01 10:00:00';
        $older->save();
        $newer = ContactMessage::create(['name' => 'Newer sender', 'email' => 'newer@example.com', 'subject' => 'Newer message', 'message' => '<script>alert("test")</script>']);
        $newer->created_at = '2026-01-02 10:00:00';
        $newer->save();
        $user = User::create(['name' => 'Reader', 'email' => 'reader@example.com', 'password' => 'test-password-123']);
        $this->actingAs($user)->get('/messages')->assertOk()
            ->assertSeeInOrder(['Newer message', 'Older message'])
            ->assertSee('2026-01-02 10:00:00')->assertSee('2026-01-01 10:00:00')
            ->assertSee('&lt;script&gt;', false)->assertDontSee('<script>alert(', false);
    }

    public function test_invalid_contact_messages_are_not_stored(): void
    {
        $this->post('/contact', ['name' => str_repeat('x', 101), 'email' => 'not-an-email',
            'subject' => str_repeat('x', 151), 'message' => 'short'])
            ->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
        $this->assertDatabaseCount('contact_messages', 0);
    }
}
