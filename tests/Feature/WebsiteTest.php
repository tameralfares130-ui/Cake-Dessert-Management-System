<?php
namespace Tests\Feature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class WebsiteTest extends TestCase {
 use RefreshDatabase;
 public function test_public_pages_are_visible():void {foreach(['/','/database','/contact','/graph','/login','/register'] as $url)$this->get($url)->assertOk();}
 public function test_guest_cannot_view_messages_or_admin():void {$this->get('/messages')->assertRedirect('/login');$this->get('/admin/confections')->assertRedirect('/login');}
 public function test_registration_cannot_choose_admin_role():void {
  $this->post('/register',['name'=>'Student','email'=>'student@example.com','password'=>'password123','password_confirmation'=>'password123','role'=>'admin'])->assertRedirect('/');
  $this->assertDatabaseHas('users',['email'=>'student@example.com','role'=>'registered']);
 }
 public function test_registered_user_cannot_access_admin():void {$user=User::create(['name'=>'Reader','email'=>'reader@example.com','password'=>'password123']);$this->actingAs($user)->get('/admin/confections')->assertForbidden();}
 public function test_admin_can_manage_confections():void {
  $user=User::create(['name'=>'Admin','email'=>'admin@example.com','password'=>'password123']);$user->role='admin';$user->save();
  $this->actingAs($user)->post('/admin/confections',['cname'=>'Test cake','type'=>'cake','prizewinning'=>'0'])->assertRedirect();
  $this->assertDatabaseHas('confections',['cname'=>'Test cake']);
 }
 public function test_contact_form_validates_and_saves():void {
  $this->post('/contact',['name'=>'Visitor'])->assertSessionHasErrors();
  $this->post('/contact',['name'=>'Visitor','email'=>'visitor@example.com','subject'=>'Question','message'=>'Can I order a cake?'])->assertRedirect('/contact');
  $this->assertDatabaseHas('contact_messages',['email'=>'visitor@example.com']);
 }
}
