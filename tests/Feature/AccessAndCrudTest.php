<?php

namespace Tests\Feature;

use App\Models\Confection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessAndCrudTest extends TestCase
{
    use RefreshDatabase;

    private function user(string $role = 'registered'): User
    {
        $user = User::create(['name' => 'Test user', 'email' => 'test@example.com', 'password' => 'test-password-123']);
        $user->role = $role;
        $user->save();
        return $user;
    }

    public function test_login_logout_and_invalid_credentials(): void
    {
        $user = $this->user();
        $this->post('/login', ['email' => $user->email, 'password' => 'wrong'])->assertSessionHasErrors('email');
        $this->assertGuest();
        $this->post('/login', ['email' => $user->email, 'password' => 'test-password-123'])->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();
        $this->get('/messages')->assertRedirect('/login');
    }

    public function test_registered_user_cannot_create_update_or_delete_confections(): void
    {
        $cake = Confection::create(['cname' => 'Protected cake', 'type' => 'cake', 'prizewinning' => 0]);
        $this->actingAs($this->user());
        $this->post('/admin/confections', ['cname' => 'Forbidden cake', 'type' => 'cake', 'prizewinning' => 0])->assertForbidden();
        $this->put('/admin/confections/'.$cake->id, ['cname' => 'Changed', 'type' => 'cake', 'prizewinning' => 1])->assertForbidden();
        $this->delete('/admin/confections/'.$cake->id)->assertForbidden();
        $this->assertDatabaseCount('confections', 1);
        $this->assertDatabaseHas('confections', ['id' => $cake->id, 'cname' => 'Protected cake']);
    }

    public function test_admin_can_read_update_and_delete_with_related_rows(): void
    {
        $cake = Confection::create(['cname' => 'Original cake', 'type' => 'cake', 'prizewinning' => 0]);
        $price = $cake->prices()->create(['price' => 1000, 'unit' => 'pce']);
        $content = $cake->contents()->create(['free' => 'G']);
        $this->actingAs($this->user('admin'));
        $this->get('/admin/confections')->assertOk()->assertSee('Original cake');
        $this->get('/admin/confections/'.$cake->id.'/edit')->assertOk();
        $this->put('/admin/confections/'.$cake->id, ['cname' => 'Updated cake', 'type' => 'pie', 'prizewinning' => -1])
            ->assertRedirect(route('admin.confections.index'));
        $this->assertDatabaseHas('confections', ['id' => $cake->id, 'cname' => 'Updated cake', 'type' => 'pie', 'prizewinning' => -1]);
        $this->delete('/admin/confections/'.$cake->id)->assertRedirect(route('admin.confections.index'));
        $this->assertDatabaseMissing('confections', ['id' => $cake->id]);
        $this->assertDatabaseMissing('prices', ['id' => $price->id]);
        $this->assertDatabaseMissing('contents', ['id' => $content->id]);
    }

    public function test_invalid_admin_input_does_not_create_or_change_records(): void
    {
        $cake = Confection::create(['cname' => 'Original cake', 'type' => 'cake', 'prizewinning' => 0]);
        $this->actingAs($this->user('admin'));
        $invalid = ['cname' => '', 'type' => '', 'prizewinning' => 42];
        $this->post('/admin/confections', $invalid)->assertSessionHasErrors(['cname', 'type', 'prizewinning']);
        $this->put('/admin/confections/'.$cake->id, $invalid)->assertSessionHasErrors(['cname', 'type', 'prizewinning']);
        $this->assertDatabaseCount('confections', 1);
        $this->assertDatabaseHas('confections', ['id' => $cake->id, 'cname' => 'Original cake']);
    }

    public function test_navigation_matches_roles(): void
    {
        $this->get('/')->assertDontSee('CRUD Admin')->assertDontSee('>Messages<', false);
        $user = $this->user();
        $this->actingAs($user)->get('/')->assertSee('>Messages<', false)->assertDontSee('CRUD Admin');
        $user->role = 'admin';
        $user->save();
        $this->actingAs($user)->get('/')->assertSee('CRUD Admin')->assertSee('>Messages<', false);
    }
}
